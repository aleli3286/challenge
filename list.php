<?php
/**
 * Created by PhpStorm.
 * Date: 2/19/2019
 * Time: 12:09 PM
 */
$listing = new \App\Controller\Listing();
$priceCalc = new \App\Model\Price();
?>
<table class="table table-condensed">
    <thead>
        <tr>
            <th>&nbsp;</th>
            <th>Name</th>
            <th>Description</th>
            <th>Item Type</th>
            <th>Pet Type</th>
            <th>Color</th>
            <th>Lifespan</th>
            <th>Age</th>
            <th>Price</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($listing->getProducts() as $product) : ?>
            <tr>
                <td>
                    <?php if ($product->image) : ?>
                        <img class="img img-responsive" width="100" src="<?php echo $product->image ?>" alt="<?php echo $product->name ?>">
                    <?php else : ?>
                        &nbsp;
                    <?php endif ?>
                </td>
                <td>
                    <?php echo $product->name ?>
                </td>
                <td><?php echo $product->description ?></td>
                <td><?php echo $product->getCategory()->name ?></td>
                <td><?php echo $product->getCustomAttribute('pet_type')->getDisplayValue() ?></td>
                <td><?php echo $product->getCustomAttribute('color')->getDisplayValue() ?></td>
                <td><?php echo $product->getCustomAttribute('lifespan')->getDisplayValue() ?></td>
                <td><?php echo $product->getCustomAttribute('age')->getDisplayValue() ?></td>
                <td style="text-align: right;">
                    <?php $price = $priceCalc->getPrice($product); ?>
                    <?php if ($price['special']) : ?>
                        <span style="text-decoration: line-through;"><?php echo sprintf('$%0.2f', $price['original']) ?></span>
                        <span><?php echo sprintf('$%0.2f', $price['special']) ?></span>
                    <?php else : ?>
                        <?php echo sprintf('$%0.2f', $price['original']) ?>
                    <?php endif ?>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>
<script type="text/javascript">
    $(document).ready(function() {
        $('table.table').dataTable({
            searching: false,
            columnDefs: [{
                targets: [0],
                orderable: false
            }],
            order: [[1, 'asc']]
        });
    })
</script>