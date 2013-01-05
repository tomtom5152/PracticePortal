<div class="pageoptions">
    {if isset($addlink)}<p class="pageoptions">{$addlink}</p>{/if}
</div>
{if !empty($questions)}
    <table class="pagetable">
        <thead>
            <tr>
                <th>ID</th>
                <th>{$question_question}</th>
                <th>{$question_locations}</th>
                <th>{$question_conditions}</th>
                <th class="pageicon"></th>
                <th class="pageicon"></th>
            </tr>
        </thead>

        <tbody>
            {foreach $questions as $question}
                <tr class="{cycle values="row1,row2"}">
                    <td>{$question.idquestions}</td>
                    <td>{$question.question}</td>
                    <td>{$question.locations}</td>
                    <td>{$question.conditions}</td>
                    <td>{$question.editlink}</td>
                    <td>{$question.deletelink}</td>
                </tr>
            {/foreach}
        </tbody>
    </table>
    <div class="pageoptions">
        {if isset($addlink)}<p class="pageoptions">{$addlink}</p>{/if}
    </div>
{/if}