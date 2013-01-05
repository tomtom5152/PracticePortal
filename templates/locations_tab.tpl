<div class="pageoptions">
    {if isset($addlink)}<p class="pageoptions">{$addlink}</p>{/if}
</div>
{if !empty($locations)}
    <div style="display: inline-block">
        <div class="treatmentMan">
            {foreach $locations as $location}
                <a href="{$location.edithref}"><div class="locationSelector" style="top:{$location.posy}px;left:{$location.posx}px;"></div></a>
            {/foreach}
        </div>
        <table class="pagetable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th class="pageicon"></th>
                    <th class="pageicon"></th>
                </tr>
            </thead>

            <tbody>
                {foreach $locations as $location}
                    <tr>
                        <td>{$location.idlocations}</td>
                        <td>{$location.locationname}</td>
                        <td>{$location.editlink}</td>
                        <td>{$location.deletelink}</td>
                    </tr>
                {/foreach}
            </tbody>
        </table>
    </div>
    <div class="pageoptions">
        {if isset($addlink)}<p class="pageoptions">{$addlink}</p>{/if}
    </div>
{/if}