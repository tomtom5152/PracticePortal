<div class="pageoptions">
    {if isset($addlink)}<p class="pageoptions">{$addlink}</p>{/if}
</div>
{if !empty($practitioners)}
    <table class="pagetable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>YouTube Video</th>
                <th>Appointment Fee</th>
                <th class="pageicon"></th>
                <th class="pageicon"></th>
            </tr>
        </thead>

        <tbody>
            {foreach $practitioners as $practitioner}
                <tr class="{cycle values="row1,row2"}">
                    <td>{$practitioner.idpractitioners}</td>
                    <td>{$practitioner.title} {$practitioner.firstname} {$practitioner.lastname}</td>
                    <td><iframe width="250" height="141" src="//www.youtube.com/embed/{$practitioner.youtube}" frameborder="0" allowfullscreen></iframe></td>
                    <td>{$practitioner.appointmentfee}</td>
                    <td>{$practitioner.editlink}</td>
                    <td>{$practitioner.deletelink}</td>
                </tr>
            {/foreach}
        </tbody>
    </table>
    <div class="pageoptions">
        {if isset($addlink)}<p class="pageoptions">{$addlink}</p>{/if}
    </div>
{/if}