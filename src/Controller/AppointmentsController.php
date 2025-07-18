<?php
declare(strict_types=1);

namespace App\Controller;

use AuditStash\Meta\RequestMetadata;
use Cake\Event\EventManager;
use Cake\Routing\Router;
use Dompdf\Dompdf;
use Dompdf\Options;
use Cake\View\View;

/**
 * Appointments Controller
 *
 * @property \App\Model\Table\AppointmentsTable $Appointments
 */
class AppointmentsController extends AppController
{
	public function initialize(): void
	{
		parent::initialize();

		$this->loadComponent('Search.Search', [
			'actions' => ['index'],
		]);
	}
	
	public function beforeFilter(\Cake\Event\EventInterface $event)
	{
		parent::beforeFilter($event);
	}

	/*public function viewClasses(): array
    {
        return [JsonView::class];
		return [JsonView::class, XmlView::class];
    }*/
	
	public function json()
    {
		$this->viewBuilder()->setLayout('json');
        $this->set('appointments', $this->paginate());
        $this->viewBuilder()->setOption('serialize', 'appointments');
    }
	
	public function csv()
	{
		$this->response = $this->response->withDownload('appointments.csv');
		$appointments = $this->Appointments->find();
		$_serialize = 'appointments';

		$this->viewBuilder()->setClassName('CsvView.Csv');
		$this->set(compact('appointments', '_serialize'));
	}
	
	public function pdfList()
	{
		$this->viewBuilder()->enableAutoLayout(false); 
        $this->paginate = [
            'contain' => ['Lecturers', 'Subjects', 'Semesters'],
			'maxLimit' => 10,
        ];
		$appointments = $this->paginate($this->Appointments);
		$this->viewBuilder()->setClassName('CakePdf.Pdf');
		$this->viewBuilder()->setOption(
			'pdfConfig',
			[
				'orientation' => 'portrait',
				'download' => true, 
				'filename' => 'appointments_List.pdf' 
			]
		);
		$this->set(compact('appointments'));
	}
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
		$this->set('title', 'Appointments List');
		$this->paginate = [
			'maxLimit' => 10,
        ];
        $query = $this->Appointments->find('search', search: $this->request->getQueryParams())
            ->contain(['Lecturers', 'Subjects', 'Semesters']);
			//->where(['title IS NOT' => null])
        $appointments = $this->paginate($query);
		
		//count
		$this->set('total_appointments', $this->Appointments->find()->count());
		$this->set('total_appointments_archived', $this->Appointments->find()->where(['status' => 2])->count());
		$this->set('total_appointments_active', $this->Appointments->find()->where(['status' => 1])->count());
		$this->set('total_appointments_disabled', $this->Appointments->find()->where(['status' => 0])->count());
		
		//Count By Month
		$this->set('january', $this->Appointments->find()->where(['MONTH(created)' => date('1'), 'YEAR(created)' => date('Y')])->count());
		$this->set('february', $this->Appointments->find()->where(['MONTH(created)' => date('2'), 'YEAR(created)' => date('Y')])->count());
		$this->set('march', $this->Appointments->find()->where(['MONTH(created)' => date('3'), 'YEAR(created)' => date('Y')])->count());
		$this->set('april', $this->Appointments->find()->where(['MONTH(created)' => date('4'), 'YEAR(created)' => date('Y')])->count());
		$this->set('may', $this->Appointments->find()->where(['MONTH(created)' => date('5'), 'YEAR(created)' => date('Y')])->count());
		$this->set('jun', $this->Appointments->find()->where(['MONTH(created)' => date('6'), 'YEAR(created)' => date('Y')])->count());
		$this->set('july', $this->Appointments->find()->where(['MONTH(created)' => date('7'), 'YEAR(created)' => date('Y')])->count());
		$this->set('august', $this->Appointments->find()->where(['MONTH(created)' => date('8'), 'YEAR(created)' => date('Y')])->count());
		$this->set('september', $this->Appointments->find()->where(['MONTH(created)' => date('9'), 'YEAR(created)' => date('Y')])->count());
		$this->set('october', $this->Appointments->find()->where(['MONTH(created)' => date('10'), 'YEAR(created)' => date('Y')])->count());
		$this->set('november', $this->Appointments->find()->where(['MONTH(created)' => date('11'), 'YEAR(created)' => date('Y')])->count());
		$this->set('december', $this->Appointments->find()->where(['MONTH(created)' => date('12'), 'YEAR(created)' => date('Y')])->count());

		$query = $this->Appointments->find();

        $expectedMonths = [];
        for ($i = 11; $i >= 0; $i--) {
            $expectedMonths[] = date('M-Y', strtotime("-$i months"));
        }

        $query->select([
            'count' => $query->func()->count('*'),
            'date' => $query->func()->date_format(['created' => 'identifier', "%b-%Y"]),
            'month' => 'MONTH(created)',
            'year' => 'YEAR(created)'
        ])
            ->where([
                'created >=' => date('Y-m-01', strtotime('-11 months')),
                'created <=' => date('Y-m-t')
            ])
            ->groupBy(['year', 'month'])
            ->orderBy(['year' => 'ASC', 'month' => 'ASC']);

        $results = $query->all()->toArray();

        $totalByMonth = [];
        foreach ($expectedMonths as $expectedMonth) {
            $found = false;
            $count = 0;

            foreach ($results as $result) {
                if ($expectedMonth === $result->date) {
                    $found = true;
                    $count = $result->count;
                    break;
                }
            }

            $totalByMonth[] = [
                'month' => $expectedMonth,
                'count' => $count
            ];
        }

        $this->set([
            'results' => $totalByMonth,
            '_serialize' => ['results']
        ]);

        //data as JSON arrays for report chart
        $totalByMonth = json_encode($totalByMonth);
        $dataArray = json_decode($totalByMonth, true);
        $monthArray = [];
        $countArray = [];
        foreach ($dataArray as $data) {
            $monthArray[] = $data['month'];
            $countArray[] = $data['count'];
        }

        $subjects = $this->Appointments->Subjects->find('list')->all();
        $lecturers = $this->Appointments->Lecturers->find('list')->all();
        $semesters = $this->Appointments->Semesters->find('list')->all();

        $this->set(compact('appointments', 'monthArray', 'countArray','subjects', 'lecturers', 'semesters'));
    }

    public function stats()
    {
		$this->set('title', 'Appointments List');
		$this->paginate = [
			'maxLimit' => 10,
        ];
        $query = $this->Appointments->find('search', search: $this->request->getQueryParams())
            ->contain(['Lecturers', 'Subjects', 'Semesters']);
			//->where(['title IS NOT' => null])
        $appointments = $this->paginate($query);

        {
            $active = $this->Appointments->find()->where(['status' => 1])->count();
            $inactive = $this->Appointments->find()->where(['status' => 2])->count();
            $onleave = $this->Appointments->find()->where(['status' => 3])->count();

            $this->set(compact('active', 'inactive', 'onleave'));
        }
		
		//count
		$this->set('total_appointments', $this->Appointments->find()->count());
		$this->set('total_appointments_archived', $this->Appointments->find()->where(['status' => 2])->count());
		$this->set('total_appointments_active', $this->Appointments->find()->where(['status' => 1])->count());
		$this->set('total_appointments_disabled', $this->Appointments->find()->where(['status' => 0])->count());
		
		//Count By Month
		$this->set('january', $this->Appointments->find()->where(['MONTH(created)' => date('1'), 'YEAR(created)' => date('Y')])->count());
		$this->set('february', $this->Appointments->find()->where(['MONTH(created)' => date('2'), 'YEAR(created)' => date('Y')])->count());
		$this->set('march', $this->Appointments->find()->where(['MONTH(created)' => date('3'), 'YEAR(created)' => date('Y')])->count());
		$this->set('april', $this->Appointments->find()->where(['MONTH(created)' => date('4'), 'YEAR(created)' => date('Y')])->count());
		$this->set('may', $this->Appointments->find()->where(['MONTH(created)' => date('5'), 'YEAR(created)' => date('Y')])->count());
		$this->set('jun', $this->Appointments->find()->where(['MONTH(created)' => date('6'), 'YEAR(created)' => date('Y')])->count());
		$this->set('july', $this->Appointments->find()->where(['MONTH(created)' => date('7'), 'YEAR(created)' => date('Y')])->count());
		$this->set('august', $this->Appointments->find()->where(['MONTH(created)' => date('8'), 'YEAR(created)' => date('Y')])->count());
		$this->set('september', $this->Appointments->find()->where(['MONTH(created)' => date('9'), 'YEAR(created)' => date('Y')])->count());
		$this->set('october', $this->Appointments->find()->where(['MONTH(created)' => date('10'), 'YEAR(created)' => date('Y')])->count());
		$this->set('november', $this->Appointments->find()->where(['MONTH(created)' => date('11'), 'YEAR(created)' => date('Y')])->count());
		$this->set('december', $this->Appointments->find()->where(['MONTH(created)' => date('12'), 'YEAR(created)' => date('Y')])->count());

		$query = $this->Appointments->find();

        $expectedMonths = [];
        for ($i = 11; $i >= 0; $i--) {
            $expectedMonths[] = date('M-Y', strtotime("-$i months"));
        }

        $query->select([
            'count' => $query->func()->count('*'),
            'date' => $query->func()->date_format(['created' => 'identifier', "%b-%Y"]),
            'month' => 'MONTH(created)',
            'year' => 'YEAR(created)'
        ])
            ->where([
                'created >=' => date('Y-m-01', strtotime('-11 months')),
                'created <=' => date('Y-m-t')
            ])
            ->groupBy(['year', 'month'])
            ->orderBy(['year' => 'ASC', 'month' => 'ASC']);

        $results = $query->all()->toArray();

        $totalByMonth = [];
        foreach ($expectedMonths as $expectedMonth) {
            $found = false;
            $count = 0;

            foreach ($results as $result) {
                if ($expectedMonth === $result->date) {
                    $found = true;
                    $count = $result->count;
                    break;
                }
            }

            $totalByMonth[] = [
                'month' => $expectedMonth,
                'count' => $count
            ];
        }

        $this->set([
            'results' => $totalByMonth,
            '_serialize' => ['results']
        ]);

        //data as JSON arrays for report chart
        $totalByMonth = json_encode($totalByMonth);
        $dataArray = json_decode($totalByMonth, true);
        $monthArray = [];
        $countArray = [];
        foreach ($dataArray as $data) {
            $monthArray[] = $data['month'];
            $countArray[] = $data['count'];
        }

        $subjects = $this->Appointments->Subjects->find('list')->all();
        $lecturers = $this->Appointments->Lecturers->find('list')->all();

        $this->set(compact('appointments', 'monthArray', 'countArray','subjects', 'lecturers'));
    }

    /**
     * View method
     *
     * @param string|null $id Appointment id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		$this->set('title', 'Appointments Details');
        $appointment = $this->Appointments->get($id, contain: ['Lecturers', 'Subjects', 'Semesters']);
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $appointment = $this->Appointments->patchEntity($appointment, $this->request->getData());
            if ($this->Appointments->save($appointment)) {
                $this->Flash->success(__('The appointment has been saved.'));

                return $this->redirect(['action' => 'view', $appointment->id]);
            }
            $this->Flash->error(__('The appointment could not be saved. Please, try again.'));
        }
		$lecturers = $this->Appointments->Lecturers->find('list', limit: 200)->all();
		$subjects = $this->Appointments->Subjects->find('list', limit: 200)->all();
		$semesters = $this->Appointments->Semesters->find('list', limit: 200)->all();
        $this->set(compact('appointment', 'lecturers', 'subjects', 'semesters'));

        $this->set(compact('appointment'));
    }


 public function approval($id = null)
{
    $appointment = $this->Appointments->get($id);

    if ($this->request->is(['patch', 'post', 'put'])) {
        $data = $this->request->getData();
        $appointment = $this->Appointments->patchEntity($appointment, $data);

        // ✅ Automatically set status to Approved if approval_status is Approved
        if ($appointment->approval_status == 1) {
            $appointment->status = 1;
        }

        if ($this->Appointments->save($appointment)) {
            $this->Flash->success(__('The appointment has been approved.'));
        } else {
            $this->Flash->error(__('The approval could not be saved. Please try again.'));
        }

        return $this->redirect(['action' => 'view', $id]);
    }

    $this->set(compact('appointment'));
}




    public function pdf($id = null)
    {
        $this->viewBuilder()->enableAutoLayout(false);
        $appointment = $this->Appointments->get($id, contain: ['Lecturers','Semesters','Subjects']);
        $this->viewBuilder()->setClassName('CakePdf.Pdf');
        $this->viewBuilder()->setOption(
            'pdfConfig',
            [
                'orientation' => 'potrait',
                'download' => true,
                'filename' => 'Appointment_'.$id. '.pdf'
            ]
        );

        $this->set('appointment', $appointment);
    }

    public function pdf2()
    {
        $this->viewBuilder()->enableAutoLayout(false);
        $appointment = $this->Appointments->find('all')-> contain (['Lecturers','Semesters','Subjects'])->all();
        $this->viewBuilder()->setClassName('CakePdf.Pdf');
        $this->viewBuilder()->setOption('pdfConfig', [
            'orientation' => 'landscape',
            'download' => true,
            'filename' => 'Appointment_Report.pdf'
        ]);

        $this->set(compact('appointment'));
    }
    

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
 public function add()
{
    $appointment = $this->Appointments->newEmptyEntity();
    if ($this->request->is('post')) {
        $appointment = $this->Appointments->patchEntity($appointment, $this->request->getData());
        
        // ✅ Set default status and approval_status to Pending
        $appointment->status = 0;
        $appointment->approval_status = 0;

        if ($this->Appointments->save($appointment)) {
            $this->Flash->success(__('The appointment has been saved.'));

            return $this->redirect(['action' => 'index']);
        }
        $this->Flash->error(__('The appointment could not be saved. Please, try again.'));
    }

    // Pass data to view
    $lecturers = $this->Appointments->Lecturers->find('list');
    $subjects = $this->Appointments->Subjects->find('list');
    $semesters = $this->Appointments->Semesters->find('list');

    $this->set(compact('appointment', 'lecturers', 'subjects', 'semesters'));
}

    /**
     * Edit method
     *
     * @param string|null $id Appointment id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$this->set('title', 'Appointments Edit');
		EventManager::instance()->on('AuditStash.beforeLog', function ($event, array $logs) {
			foreach ($logs as $log) {
				$log->setMetaInfo($log->getMetaInfo() + ['a_name' => 'Edit']);
				$log->setMetaInfo($log->getMetaInfo() + ['c_name' => 'Appointments']);
				$log->setMetaInfo($log->getMetaInfo() + ['ip' => $this->request->clientIp()]);
				$log->setMetaInfo($log->getMetaInfo() + ['url' => Router::url(null, true)]);
				$log->setMetaInfo($log->getMetaInfo() + ['slug' => $this->Authentication->getIdentity('slug')->getIdentifier('slug')]);
			}
		});
        $appointment = $this->Appointments->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $appointment = $this->Appointments->patchEntity($appointment, $this->request->getData());
            if ($this->Appointments->save($appointment)) {
                $this->Flash->success(__('The appointment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The appointment could not be saved. Please, try again.'));
        }
		$lecturers = $this->Appointments->Lecturers->find('list', limit: 200)->all();
		$subjects = $this->Appointments->Subjects->find('list', limit: 200)->all();
		$semesters = $this->Appointments->Semesters->find('list', limit: 200)->all();
        $this->set(compact('appointment', 'lecturers', 'subjects', 'semesters'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Appointment id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
		EventManager::instance()->on('AuditStash.beforeLog', function ($event, array $logs) {
			foreach ($logs as $log) {
				$log->setMetaInfo($log->getMetaInfo() + ['a_name' => 'Delete']);
				$log->setMetaInfo($log->getMetaInfo() + ['c_name' => 'Appointments']);
				$log->setMetaInfo($log->getMetaInfo() + ['ip' => $this->request->clientIp()]);
				$log->setMetaInfo($log->getMetaInfo() + ['url' => Router::url(null, true)]);
				$log->setMetaInfo($log->getMetaInfo() + ['slug' => $this->Authentication->getIdentity('slug')->getIdentifier('slug')]);
			}
		});
        $this->request->allowMethod(['post', 'delete']);
        $appointment = $this->Appointments->get($id);
        if ($this->Appointments->delete($appointment)) {
            $this->Flash->success(__('The appointment has been deleted.'));
        } else {
            $this->Flash->error(__('The appointment could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
	
	public function archived($id = null)
    {
		$this->set('title', 'Appointments Edit');
		EventManager::instance()->on('AuditStash.beforeLog', function ($event, array $logs) {
			foreach ($logs as $log) {
				$log->setMetaInfo($log->getMetaInfo() + ['a_name' => 'Archived']);
				$log->setMetaInfo($log->getMetaInfo() + ['c_name' => 'Appointments']);
				$log->setMetaInfo($log->getMetaInfo() + ['ip' => $this->request->clientIp()]);
				$log->setMetaInfo($log->getMetaInfo() + ['url' => Router::url(null, true)]);
				$log->setMetaInfo($log->getMetaInfo() + ['slug' => $this->Authentication->getIdentity('slug')->getIdentifier('slug')]);
			}
		});
        $appointment = $this->Appointments->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $appointment = $this->Appointments->patchEntity($appointment, $this->request->getData());
			$appointment->status = 2; //archived
            if ($this->Appointments->save($appointment)) {
                $this->Flash->success(__('The appointment has been archived.'));

				return $this->redirect($this->referer());
            }
            $this->Flash->error(__('The appointment could not be archived. Please, try again.'));
        }
        $this->set(compact('appointment'));
    }
}
