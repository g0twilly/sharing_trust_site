<?php $this->load->view('partials/header'); ?>
<div id="container" class="container">
    <div class="logo">
        <img src="/img/logo.png" alt="<?= i18n('the_exchange');?>" title="<?= i18n('the_exchange');?>" class="center-block img-responsive" />
    </div>

    <div id="about">
        <h3><?= i18n("about_us");?></h3>

        <div class="copy">
            <?= i18n('about_copy');?>
        </div>

        <div class="getstarted"><a href="<?= (can_signup()) ? '/account/signup/' : '/account/login/'; ?>" class="btn btn-teal btn-lg"><?= i18n('get_started');?></a></div>
    </div>
        <div class="more_information col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
                    <p>More Information:</p>
                    <div class="more_information_info">
        <p>You are invited to participate in a research study about the effect of participation in online communities on your social life. We are particularly interested in learning how your interactions with people evolve over time. For this reason, we ask that you participate in playing The Exchange! a total of three times.</p>
        <p>If you agree to be part of the research study, you will be asked to answer some preliminary questions and participate in two games (at the most). The preliminary questions are related to your experience with online communities. We will also ask for your name and email address. We will use this information to send you reminders to participate again within three months of the last time you played.</p>
        <p>One game is a “lottery” game, where you will be asked to make choices between alternative scenarios that involve winning different amounts of points. Another game is an “investment” game, where you will play against another participant and decide how many points to give to her/him or keep for yourself.</p>
        <p>The data we will be collecting from you will be kept in a secure facility at Stanford University. Only the Primary Investigator (PI) and Co-PI of this project will have full access to your private information (i.e. email address). To learn more about the research team behind this please visit <a href= "http://www.stanford.edu/~pparigi/TheExchange.html">http://www.stanford.edu/~pparigi/TheExchange.html</a>.</p>
        <p>There are no risks or benefits to you associated with this research.</p>
        <p>Participation in this study is completely voluntary. You have to be at least 18 years old to participate in this study. Even if you decide to participate now, you may change your mind and stop at any time. You may choose not to answer any of the questions or to stop playing the games for any reasons. You may choose to ignore our reminders and not come back to play the games.</p>
        <p>If you have questions about this study, you may contact Paolo Parigi at (650) 721-2648 or by email at pparigi@stanford.edu.<p>
        <p>The Stanford University Institutional Review Board (IRB) has determined that this meets all requirements of the IRB (Protocol Approval date: 4/25/2014. Protocol Expiration date: 4/25/2015. Extended to 3/31/2016).</p>
        <p>If you are not satisfied with how this study is being conducted, or if you have any concerns or general questions about the research or your rights as a participant, please contact the Stanford IRB to speak to someone independent of the research team at (650) 723-2480 or toll free at 1-866-680-2906. You can also write to the Stanford IRB, Stanford University, 3000 El Camino Real, Five Palo Alto Square, 4th Floor, Palo Alto, CA 94306. </p>
                </div>
</div>
<?php $this->load->view('partials/footer'); ?>
