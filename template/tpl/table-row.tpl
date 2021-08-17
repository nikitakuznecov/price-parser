{if $Products}
    {foreach $Products as $key => $value}
    <tr class="animated fadeIn">
        <td>{$value->getId()}</td>
        <td>{$value->getName()}</td>
        <td>{$value->getPrice()}</td>
    </tr>
    {/foreach}
{/if}