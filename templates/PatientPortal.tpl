<script src="//code.jquery.com/jquery.min.js"></script>
<noscript><div class="scripterror">You do not appear to have JavaScript enabled in your browser. It is not possible to use the Practice Portal without JavaScript. Please consult your browsers documentation for details on how to enable JavaScript.</div></noscript>
<div class="PracticePortal">
    <div class="introduction">
        {$settings.maintitle}
        {$settings.introbody}
        <button class="conditionknown stageskip">{$settings.conditionknown}</button>
    </div>
    <div class="treatmentMan">
        {foreach $locations as $location}
            <button class="locationSelector" data-idlocations='{$location.idlocations}'
                    data-idquestions='{$location.idquestions}'
                    style="left:{$location.posx}px;top:{$location.posy}px;"></button>
        {/foreach}
    </div>
    <div class="locationQuestions">
        <button class="locationQuestionsCancel">Cancel</button>
        {foreach $questions as $question}
            <button class="questionSelector" data-idquestions='{$question.idquestions}'>
                {$question.question}
            </button>
            <div class="questionContent" data-idquestions='{$question.idquestions}'>
                <button class="questionContentClose">&raquo;</button>
                {$question.content}
                <h4>It is possible that you may have one of the following conditions</h4>
                {foreach $question.conditions as $condition}
                    <button class="conditionOption" data-idconditions="{$condition.idconditions}">
                        {$condition.conditionname}
                    </button>
                {/foreach}
            </div>
        {/foreach}
    </div>
    <div class="conditionList">
        <button class="conditionListCancel block">Cancel</button>
        <h4>Please select your condition from the list bellow:</h4>
        {foreach $conditions as $condition}
            <button class="conditionOption" data-idconditions="{$condition.idconditions}">
                {$condition.conditionname}
            </button>
        {/foreach}
    </div>
    <div class="conditions">
        {foreach $conditions as $condition}
            <div class="condition" data-idconditions="{$condition.idconditions}">
                <button class="conditionCancel">Cancel</button>
                <h4>{$condition.conditionname}</h4>
                {$condition.content}
                <h5>You could be treated by the following practitioners:</h5>
                {foreach $condition.practitioners as $practitioner}
                    <button class="practitionerOption" data-idpractitioners="{$practitioner.idpractitioners}">
                        <iframe class="practitionerOptionVideo" width="200" height="113" data-src="//www.youtube.com/embed/{$practitioner.youtube}" frameborder="0" allowfullscreen></iframe>
                        <div class="practitionerOptionName"><h6>{$practitioner.title} {$practitioner.firstname} {$practitioner.lastname}</h6></div>
                        <div class="practitionerOptionBio">{$practitioner.bio|truncate:500}</div>
                    </button>
                {/foreach}
            </div>
        {/foreach}
    </div>
    <div class="practitioners">
        {foreach $practitioners as $practitioner}
            <div class="practitioner" data-idpractitioners="{$practitioner.idpractitioners}">
                <button class="practitionerCancel">Cancel</button>
                <h4>{$practitioner.title} {$practitioner.firstname} {$practitioner.lastname}</h4>
                <iframe class="practitionerOptionVideo" width="280" height="158" src="//www.youtube.com/embed/{$practitioner.youtube}" frameborder="0" allowfullscreen></iframe>
                <div class="practitionerBio">{$practitioner.bio}</div>
            </div>
        {/foreach}
    </div>
</div>
<script>
    if($.cookie == undefined)
        $('head').append("<script src='{$portaldir}/lib/jquery.cookie.js'><\/script>");
</script>
<script src="{$portaldir}/lib/PracticePortal.js"></script>