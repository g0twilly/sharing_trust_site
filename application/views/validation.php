<?php $this->load->view('partials/header'); ?>
<div id="container" class="container">
    <div class="logo">
        <img src="/img/logo.png" alt="<?= i18n('the_exchange');?>" title="<?= i18n('the_exchange');?>" class="center-block img-responsive" />
    </div>

    <div id="validation">
        <h3><?= i18n('validation_thankyou');?></h3>
<?php if ($status == 'duplicate') : ?>
        <div class="row alert alert-danger" id="sms_activity">
          <p><?= i18n('phone_duplicate');?> <?= i18n('validation_contact', safe_mailto("pparigi@stanford.edu"));?></p>
        </div>
<?php elseif ($action == 'phone_info') : ?>
        <div class="row alert alert-white" id="sms_activity">
            <h3><?= i18n('validation_box');?></h3>
            <div id="signup">
                <?= form_open('/save_phone_data') ?>
                    <div class="row signup_item">
                        <label><?= i18n('mobile_phone');?> : </label>
                        <input id="mobile_number" name="phone" class="text_input" type="tel" value="<?= set_value('phone'); ?>" />
                        <?= form_error('phone'); ?>
                    </div>
                    <div class="row signup_item">
                        <label><?= i18n('mobile_carrier');?> : </label>
                        <select class="select_input" name="mobile_carrier" id="mobile_carrier">
                        <option value="" disabled <?= set_select('mobile_carrier', '', TRUE); ?><?
                            if (!($this->input->post('mobile_carrier'))) : ?> selected="selected"<? endif;?>><?= i18n('select_one');?></option>
                        <?php foreach ($mobile_carriers as $key => $value): ?>
                            <option <?= set_select('mobile_carrier', $key);?> value="<?= $key ;?>"><?=$value['name'];?></option>
                        <?php endforeach ?>
                        </select>
                        <?= form_error('mobile_carrier'); ?>
                    </div>
                    <div class="submit">
                        <input class="btn btn-teal" type="submit" name="submit" value="<?=i18n('send_text');?>" />
                    </div>
                </form>
            </div>
        </div>
<?php elseif ($action == 'sms_input') : ?>
        <div class="row alert alert-white" id="sms_activity">
            <h3><?= i18n('validation_box2');?></h3>
            <div id="signup">
                <?= form_open('/code_verify') ?>
                    <div class="row signup_item">
                        <label><?= i18n('enter_code');?> : </label>
                        <input id="vericode" name="vericode" class="text_input" type="text" value="<?= set_value('vericode'); ?>" />
                        <?= form_error('vericode'); ?>
                    </div>
                    <div class="submit">
                        <input class="btn btn-teal" type="submit" name="submit" value="<?=i18n('submit');?>" />
                    </div>
                </form>
                <hr />
                <?php if ($sms_button) : ?>
                    <?= form_open('/code_verify') ?>
                        <div class="submit text-right">
                            <input class="btn btn-danger" type="submit" name="resend_sms" value="<?=i18n('resend_sms');?>" />
                        </div>
                    </form>
                <?php endif;?>
            </div>
        </div>
<?php elseif ($action == 'overage') : ?>
        <div class="row alert alert-danger" id="sms_activity">
            <p><?= i18n('attempts_overage');?> <?= i18n('validation_contact', safe_mailto("pparigi@stanford.edu"));?></p>
        </div>
<?php endif; ?>
    </div>
</div>
<?php $this->load->view('partials/footer'); ?>