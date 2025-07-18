<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Appointment $appointment
 */
?>

<?php
function formatMalayDate($date) {
    $months = [
        '01' => 'Januari', '02' => 'Februari', '03' => 'Mac', '04' => 'April',
        '05' => 'Mei', '06' => 'Jun', '07' => 'Julai', '08' => 'Ogos',
        '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Disember'
    ];
    $timestamp = strtotime($date);
    $day = date('j', $timestamp);
    $month = $months[date('m', $timestamp)];
    $year = date('Y', $timestamp);
    return "$day $month $year";
}
?>

<!--Header-->
<div class="row text-body-secondary">
	<div class="col-10">
		<h1 class="my-0 page_title">Correspondence Details</h1>
		<h6 class="sub_title text-body-secondary"><?php echo $system_name; ?></h6>
	</div>
	<div class="col-2 text-end">
		<div class="dropdown mx-3 mt-2">
			<button class="btn p-0 border-0" type="button" id="orederStatistics" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<i class="fa-solid fa-bars text-primary"></i>
			</button>
				<div class="dropdown-menu dropdown-menu-end" aria-labelledby="orederStatistics">
							<li><?= $this->Html->link(__('Edit Appointment'), ['action' => 'edit', $appointment->id], ['class' => 'dropdown-item', 'escapeTitle' => false]) ?></li>
				<li><?= $this->Form->postLink(__('Delete Appointment'), ['action' => 'delete', $appointment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $appointment->id), 'class' => 'dropdown-item', 'escapeTitle' => false]) ?></li>
				<li><hr class="dropdown-divider"></li>
				<li><?= $this->Html->link(__('List Appointments'), ['action' => 'index'], ['class' => 'dropdown-item', 'escapeTitle' => false]) ?></li>
				<li><?= $this->Html->link(__('New Appointment'), ['action' => 'add'], ['class' => 'dropdown-item', 'escapeTitle' => false]) ?></li>
							</div>
		</div>
    </div>
</div>
<div class="line mb-4"></div>
<!--/Header-->

<style>
    .light{
        background-color: #ffffff;
        color: #000000;
    }
        @page{
            margin: 0px 0px 0px 0px !important;
            padding: 0px 0px 0px 0px !important;
        }

        body{
            font-family: Arial, Helvetica, sans-serif;
            font-size: 13px;
        }

        .justify {
        text-align: justify;
        }
</style>

<div class="row">
  <div class="col-md-9">
    <div class="card rounded-0 mb-3 light border-0 shadow justify">
        <?php echo $this->Html->image('top.png',['width'=>'100%']); ?>
        <div class="card-body px-0">
            <table border="0" class="text-end mt-3 mb-3 mx-5">
                <tr>
                    <td width="50%">Surat Kami</td>
                    <td width="1%">:</td>
                    <td width="10%">UiTM-Exam/<?= h($appointment->id) ?></td>
                </tr>
                <tr>
                    <td>Tarikh</td>
                    <td>:</td>
                    <td><?php echo date('d F Y', strtotime
                    ($appointment->created)); ?></td>
                </tr>
            </table>

        <div class="mx-5 justify">
            <div class="fw-bold capital">
            <?php echo ($appointment->lecturer->name); ?></div>
            Pensyarah Kanan <br/>
            Pusat Pengajian Sains Maklumat <br/>
            Fakulti Sains Maklumat <br/>
            UiTM Kampus Puncak Perdana<br/>
            40150 Shah Alam<br/>
            Selangor
            <br/><br/>

            Salam Sejahtera
            <br/><br/>

            Tuan/Puan
            <br/><br/>

            <style>
                .capital{
                    text-transform: uppercase;
                }
            </style>

            <div class="fw-bold capital mb-4">
                PELANTIKAN SEBAGAI RESOURCE PERSON (RP) BAGI PROGRAM SARJANA MUDA SAINS MAKLUMAT (KEPUJIAN) PENGURUSAN SISTEM MAKLUMAT (CDIM262)
                <br/>
                <table border="0" class="text-start mt-3 mb-3">
                    <tr>
                        <td width="0%">KOD KURSUS</td>
                        <td width="0%">:</td>
                        <td width="0%"><?php echo ($appointment->subject->code); ?></td>
                    </tr>
                    <tr>
                        <td>NAMA KURSUS</td>
                        <td>:</td>
                        <td> <?php echo ($appointment->subject->name); ?></td>
                    </tr>
                </table>
            </div>

            Dengan hormatnya perkara di atas adalah dirujuk.
            <br/><br/>

            2. Dimaklumkan bahawa Tuan/Puan adalah dilantik sebagai Resource Person (RP) bagi Kod Kursus <strong><?php echo ($appointment->subject->code); ?></strong> mulai <strong><?= formatMalayDate($appointment->start_date); ?> hingga <?= formatMalayDate($appointment->end_date); ?></strong> di <strong><?php echo ($appointment->location); ?></strong>.
            <br/><br/>

            3. Pelantikan ini adalah berdasarkan kepakaran dan pengalaman tuan bagi kod kursus tersebut.
            Dengan ini tuan diberi tanggungjawab untuk menyumbang terhadap pembangunan program dan
            melaksanakan tugas dengan komited serta berdedikasi demi meningkatkan kualiti pembangunan
            akademik khususnya di peringkat Fakulti Sains Maklumat (FSM).
            <br/><br/>
            4. Sehubungan dengan itu, tuan diminta untuk menghubungi Ketua Pengajian Sains Maklumat
            mengenai tugasan di atas pelantikan ini.
            <br/><br/>

            Sekian, kerjasama dan keprihatinan tuan amatlah dihargai dan didahului dengan ucapan terima kasih.
            <br/><br/>

            <strong>
            <br/>"MALAYSIA MADANI"<br/>
            "BERKHIDMAT UNTUK NEGARA"
            <br/><br/>
            </strong>

            Saya yang menjalankan amanah,
            <br/><br/><br/>

            <strong><?php echo ($appointment->approval_name); ?></strong><br/>
            <?php echo ($appointment->approval_post); ?> <br/>
            Fakulti Sains Maklumat<br/>
            <?php echo $this->Html->image('bottom.png',['width'=>'100%']); ?>
            </div>
            </div>
        </div>

	</div>
	<div class="col-md-3">
        <div class="card bg-body-tertiary">
            <div class="card-body">
                <div class="card-title">Action</div>
                <div class="tricolor_line mb-3"></div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tr>
                            <td>Name</td>
                            <td><?php echo ($appointment->lecturer->name); ?></td>
                        </tr> 
                        <tr>
                            <td>Created</td>
                            <td><?php echo date('d F Y', strtotime
                            ($appointment->created)); ?></td>
                        </tr>  
                    </table>
                    
                    <?php echo $this->html->link(__('Download PDF'),['action'=>'pdf',
                    $appointment->id], ['class'=> 'btn btn-outline-primary btn-sm']);?>
                </div>
            </div>
        </div>
	</div>
</div>