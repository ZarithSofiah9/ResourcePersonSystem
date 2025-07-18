<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Subject $subject
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
                ['action' => 'delete', $subject->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $subject->id), 'class' => 'dropdown-item', 'escapeTitle' => false]
            ) ?>
            <?= $this->Html->link(__('List Subjects'), ['action' => 'index'], ['class' => 'dropdown-item', 'escapeTitle' => false]) ?>
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
                Please enter the subject information correctly. This data will be used for appointment assignments and course records:
                    <ul>
                        <li>Provide a clear and complete subject name.</li>
                        <li>Enter subject code (e.g., "CS101", "MGT203").</li>
                        <li>Indicate the correct number of credit hours.</li>
                    </ul>
                    Ensure all fields are reviewed before saving.
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div class="card shadow border-0 bg-body-tertiary">
            <div class="card-body">
                    <?= $this->Form->create($subject) ?>
                    <fieldset>

                    	<div class="row">
							<div class="col-md-6">
								<?php echo $this->Form->control('name'); ?>
							</div>

							<div class="col-md-6">
								<?php echo $this->Form->control('code'); ?>
							</div>

							<div class="col-md-6">
								<?php echo $this->Form->control('credit_hour',[
													'options' => [
														'1.0'=>'1.0',
														'2.0'=>'2.0',
														'3.0'=>'3.0',
														'4.0'=>'4.0'
													],
													'empty' => 'Select Credit Hour',
													'class' => 'form-control form-select'
												]); ?>
							</div>
							
							<div class="col-md-6">
								<?php echo $this->Form->control('status',[
													'options' => [
														'1'=>'Active',
														'2'=>'Inactive',
														'3'=>'Under Development'
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