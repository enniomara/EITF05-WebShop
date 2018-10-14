<tr>
    <th><?php echo $this->escape($item->getName()) ?></th>
    <th><?php echo intval($cart->getAmount($item)) ?> st</th>
    <th><?php echo intval($item->getPrice()) ?> kr</th>
    <th><?php echo intval($item->getPrice()) * $cart->getAmount($item) ?> kr </th>
</tr>'
