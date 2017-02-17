<?php $this->load->view('partials/header'); ?>
<div id="container" class="container">
    <div class="logo">
        <img src="/img/logo.png" alt="<?= i18n('the_exchange');?>" title="<?= i18n('the_exchange');?>" class="center-block img-responsive" />
    </div>

    <div id="signup">
        <h2>
            <?= i18n('sign_up'); ?>
            <span class="required_label">(<?= i18n('required_field');?>)</span>
        </h2>
<?php if (validation_errors()) : ?>
<div class="alert alert-danger">
    <?php if (form_error('ip_address')) : ?>
        <strong><?= form_error('ip_address');?></strong>
    <? elseif ($this->session->flashdata('duplicate_username') != '') : ?>
        <div class="alert alert-info">
            <?= i18n('duplicate_username');?>
        </div>
    <? elseif ($this->session->flashdata('invalid_email') != '') : ?>
        <div class="alert alert-info">
            <?= i18n('invalid_email');?>
        </div>
    <?php else : ?>
        <strong><?= i18n('signup_errors'); ?></strong>
    <?php endif;?>
</div>
<?php endif; ?>

    <div class="panel">
        <div class="panel-body">
            <div class="profile_signup">
                <p><?= i18n('signup_instructions');?></p>
            </div>
        </div>
    </div>


<?= form_open('account/signup', '', $hidden) ?>

    <div class="signup_item">
        <label for="first_name"><?= i18n('first_name'); ?> </label>
        <input type="text" class="text_input" name="first_name" value="<?= set_value('first_name'); ?>" placeholder="<?= i18n('eg_first_name');?>">
        <?= form_error('first_name'); ?>
    </div>

    <div class="signup_item">
        <label for="last_name"><?= i18n('last_name'); ?> </label>
        <input type="text" class="text_input" name="last_name" value="<?= set_value('last_name'); ?>" placeholder="<?= i18n('eg_last_name');?>">
        <?= form_error('last_name'); ?>
    </div>

    <div class="signup_info col-sm-8 col-sm-offset-2">
        <div class="alert alert-info">
            <p><?= i18n('first_and_last_name_required');?></p>
        </div>
    </div>

    <hr class="full_width">

    <div class="signup_item">
        <label for="gender"><?= i18n('gender'); ?> *</label>
        <select id="gender" class="select_input" name="gender">
            <option value="" disabled <?= set_select('gender', '', TRUE); ?><?
            if (!($this->input->post('gender'))) : ?> selected="selected"<? endif;?>><?= i18n('select_one');?></option>
        <?php
        foreach (array('male', 'female') as $g) : ?>
            <option <?= set_select('gender', $g);?> value="<?= $g ?>"><?= i18n($g); ?></option>
        <?php
        endforeach;
        ?>
        </select>
        <?= form_error('gender');?>
    </div>

    <div class="signup_item">
        <label for="age"><?= i18n('age'); ?> *</label>
        <select class="select_input" name="age">
            <option value="" disabled <?= set_select('age', '', TRUE); ?>><?= i18n('select_one');?></option>
            <?php
            for ($i=18;$i<=80;$i++) : ?>
            <option <?= set_select('age', $i);?> value="<?= $i ?>"><?= $i ?></option>
            <?php
            endfor;
            ?>
        </select>
        <?= form_error('age'); ?>
    </div>


    <div class="signup_item">
        <label for="zip"><?= i18n('zipcode'); ?> * <span style="font-weight:normal;"></label>
        <input type="text" class="text_input" name="zip" value="<?= set_value('zip'); ?>" placeholder="<?= i18n('eg_zipcode');?>">
        <?= form_error('zip'); ?>
    </div>

    <div class="signup_item">
        <label for="marital_status"><?= i18n('marital_status'); ?> *</label>
        <select id="marital_status" class="select_input" name="marital_status">
            <option value="" disabled <?= set_select('marital_status', '', TRUE); ?><?
            if (!($this->input->post('marital_status'))) : ?> selected="selected"<? endif;?>><?= i18n('select_one');?></option>
        <?php
        foreach (array('married', 'single') as $ms) : ?>
            <option <?= set_select('marital_status', $ms);?> value="<?= $ms ?>"><?= i18n($ms); ?></option>
        <?php
        endforeach;
        ?>
        </select>
        <?= form_error('marital_status');?>
    </div>

    <div class="submit">
        <input class="btn btn-teal" type="submit" name="submit" value="<?=i18n('continue');?>" />
    </div>
    <div class="signup_info col-sm-8 col-sm-offset-2">
        <div class="alert alert-info">
    		<p><?= i18n('required_for_eligibility');?></p>
        </div>
    </div>


</form>
    </div>
</div>
<?php $this->load->view('partials/footer'); ?>
