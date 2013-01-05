<div class="pageoptions">
    {if isset($addlink)}<p class="pageoptions">{$addlink}</p>{/if}
</div>
{if !empty($conditions)}
    <table class="pagetable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Condition Name</th>
                <th>Qualified Practitioners</th>
                <th class="pageicon"></th>
                <th class="pageicon"></th>
            </tr>
        </thead>

        <tbody>
            {foreach $conditions as $condition}
                <tr class="{cycle values="row1,row2"}">
                    <td>{$condition.idconditions}</td>
                    <td>{$condition.conditionname}</td>
                    <td>{$condition.practitioners}</td>
                    <td>{$condition.editlink}</td>
                    <td>{$condition.deletelink}</td>
                </tr>
            {/foreach}
        </tbody>
    </table>
    <div class="pageoptions">
        {if isset($addlink)}<p class="pageoptions">{$addlink}</p>{/if}
    </div>
{/if}