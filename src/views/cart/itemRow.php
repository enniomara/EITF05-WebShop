<tr>
    <th><?php echo $this->escape($item->getName()) ?></th>
    <td><?php echo intval($cart->getAmount($item)) ?> st</td>
    <td><?php echo intval($item->getPrice()) ?> kr</td>
    <td><?php echo intval($item->getPrice()) * $cart->getAmount($item) ?> kr </td>
</tr>'
