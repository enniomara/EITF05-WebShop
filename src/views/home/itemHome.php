<div class="col-lg-4 col-md-5 mb-4">
    <form action="cart.php?action=add" method="post">
        <div class="card">
            <img class="card-img-top" src="http://placehold.it/500x325" alt="">

            <div class="card-body">
                <h3 class="card-title"><?php echo $this->escape($item->getName()) ?></h3>
                <h4><?php echo $this->escape($item->getPrice()) ?>kr</h4>
            </div>
            <div class="card-footer">
                <input type="number"
                       min="0"
                       class="form-control"
                       name="<?php echo intval($item->getId()) ?>"
                       placeholder="Antal"
                />
                <br>
                <input class="btn btn-primary" type="submit" value="Add item to cart">
            </div>

        </div>
    </form>
</div>
