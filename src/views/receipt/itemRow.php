<tr>
    <td class="col-md-9"><em><?php echo $this->escape($item->getName()); ?></em></h4></td>
    <td class="col-md-1" style="text-align: center"><?php echo intval($cart->getAmount($item)); ?></td>
    <td class="col-md-1 text-center"><?php echo intval($item->getPrice()); ?></td>
    <td class="col-md-1 text-center"><?php echo intval($item->getPrice()) * intval($cart->getAmount($item)); ?></td>
</tr>
