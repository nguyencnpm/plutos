<?php
defined('_JEXEC') or die;
?>
<div class="row-fluid">
    <div class="span6"><?php echo $this->form->getControlGroup('catid'); ?></div>
    <div class="span6"><?php echo $this->form->getControlGroup('product_id'); ?></div>
</div>
<div class="well">
    <div class="row-fluid datepicker_date">
        <!--        
        <div class="span2"><?php // echo JText::_('Period');   ?></div>
                <div class="span5"><?php //echo $this->form->getInput('start_date');    ?></div>
                <div class="span5"><?php //echo $this->form->getInput('expiry_date');    ?></div>
        -->
    </div>
    <div class="row-fluid datepicker_date">
        <div class="span12"><?php echo $this->form->getControlGroup('periodDate'); ?></div>
    </div>
    <div class="clearfix">&nbsp;</div>
    <div class="row-fluid">
        <div class="span12">
            <table class="table table-striped" id="checkList">
                <thead>
                    <tr>
                        <th width="" class="nowrap center text-info"><?php echo JText::_('JGLOBAL_CHECK_ALL'); ?></th>
                        <th width="" class="nowrap center text-error"><?php echo $this->form->getLabel('sunday'); ?></th>
                        <th width="" class="nowrap center"><?php echo $this->form->getLabel('monday'); ?></th>
                        <th width="" class="nowrap center"><?php echo $this->form->getLabel('tuesday'); ?></th>
                        <th width="" class="nowrap center"><?php echo $this->form->getLabel('wednesday'); ?></th>
                        <th width="" class="nowrap center"><?php echo $this->form->getLabel('thursday'); ?></th>
                        <th width="" class="nowrap center"><?php echo $this->form->getLabel('friday'); ?></th>
                        <th width="" class="nowrap center text-warning"><?php echo $this->form->getLabel('saturday'); ?></th>
                    </tr>    
                </thead>
                <tbody>
                    <tr class="row1">
                        <td class="nowrap center"><input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="checkAll(this)" /></td>
                        <td class="nowrap center"><?php echo $this->form->getInput('sunday'); ?></td>
                        <td class="nowrap center"><?php echo $this->form->getInput('monday'); ?></td>
                        <td class="nowrap center"><?php echo $this->form->getInput('tuesday'); ?></td>
                        <td class="nowrap center"><?php echo $this->form->getInput('wednesday'); ?></td>
                        <td class="nowrap center"><?php echo $this->form->getInput('thursday'); ?></td>
                        <td class="nowrap center"><?php echo $this->form->getInput('friday'); ?></td>
                        <td class="nowrap center"><?php echo $this->form->getInput('saturday'); ?></td>

                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="clearfix">&nbsp;</div>
    <div class="row-fluid">
        <div class="span6"><?php echo $this->form->getControlGroup('allotment'); ?></div>
        <div class="span6">
            <?php echo $this->form->getControlGroup('sunsat'); ?>
            <div class="text-error"><?php echo $this->form->getControlGroup('allotment_sunday'); ?></div>
            <div class="text-warning"><?php echo $this->form->getControlGroup('allotment_saturday'); ?></div>
        </div>
    </div>
</div>
