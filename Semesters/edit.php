<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Semester $semester
 */
?>
<!--Header-->
<div class="row text-body-secondary">
	<div class="col-10">
		<h1 class="my-0 page_title"><?php echo $title; ?></h1>
		<h6 class="sub_title text-body-secondary"><?php echo $system_name; ?></h6>
	</div>
	<div class="col-2 text-end">
		<div class="dropdown mx-3 mt-2">
			<button class="btn p-0 border-0" type="button" id="orederStatistics" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<i class="fa-solid fa-bars text-primary"></i>
			</button>
				<div class="dropdown-menu dropdown-menu-end" aria-labelledby="orederStatistics">
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $semester->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $semester->id), 'class' => 'dropdown-item', 'escapeTitle' => false]
            ) ?>
            <?= $this->Html->link(__('List Semesters'), ['action' => 'index'], ['class' => 'dropdown-item', 'escapeTitle' => false]) ?>
				</div>
		</div>
    </div>
</div>
<div class="line mb-4"></div>
<!--/Header-->

<div class="row">
    <div class="col-md-3">
        <div class="card shadow border-0 bg-body-tertiary">
            <div class="card-body justify">
                <div class="card_title">Instruction</div>
                <div class="tricolor_line mb-3"></div>
                Please create and manage semester information with care. This defines the academic timeline for appointments and course delivery:
                    <ul>
                        <li>Use a descriptive name (e.g., "Mac - Ogos 2025").</li>
                        <li> Assign a unique semester code (e.g., "20252").</li>
                    </ul>
                    Confirm that the semester name and code do not duplicate existing records.
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div class="card shadow border-0 bg-body-tertiary">
            <div class="card-body">
                    <?= $this->Form->create($semester) ?>
                    <fieldset>

                    	<div class="row">
							<div class="col-md-12">
								<?php echo $this->Form->control('code'); ?>
							</div>

							<div class="col-md-12">
								<?php echo $this->Form->control('name'); ?>
							</div>

							<div class="col-md-12">
								<?php echo $this->Form->control('status',[
													'options' => [
														'1'=>'Ongoing',
														'2'=>'Upcoming',
														'3'=>'Completed'
													],
													'empty' => 'Select Status',
													'class' => 'form-control form-select'
												]); ?>
							</div>
						</div>

            </fieldset>
				<div class="text-end">
				  <?= $this->Form->button('Reset', ['type' => 'reset', 'class' => 'btn btn-outline-warning']); ?>
				  <?= $this->Form->button(__('Submit'),['type' => 'submit', 'class' => 'btn btn-outline-primary']) ?>
                </div>
        <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>