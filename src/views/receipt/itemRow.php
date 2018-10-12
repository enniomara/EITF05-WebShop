<tr>
    <td class="col-md-9"><em><?php echo $item->getName(); ?></em></h4></td>
    <td class="col-md-1" style="text-align: center"><?php echo $cart->getAmount($item); ?></td>
    <td class="col-md-1 text-center"><?php echo $item->getPrice(); ?></td>
    <td class="col-md-1 text-center"><?php echo $item->getPrice() * $cart->getAmount($item); ?></td>
</tr>