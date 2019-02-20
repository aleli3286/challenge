<?php
/**
 * Created by PhpStorm.
 * Date: 2/19/2019
 * Time: 12:10 PM
 */
$attributes = \App\Kernel\Container::getInstance()->get('attribute')->findBy(['is_visible' => 1]);
$categories = \App\Kernel\Container::getInstance()->get('category')->getAll();
$filterValues = \App\Kernel\Container::getInstance()->get('session')->get('filter', []);
?>
<div style="border: 1px solid #9a9a9b; padding: 10px;">
    <form id="form-filter" action="filter.php" method="post">
        <h2>Filter</h2>
        <div class="row">
            <div class="col-sm-3 form-group">
                <label for="filter_category_id">Item Type</label>
                <select name="filter[category_id]" id="filter_category_id" class="form-control">
                    <option value=""<?php echo !isset($filterValues['category_id']) ? ' selected' : '' ?>>Any</option>
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?php echo $category->id ?>"<?php echo isset($filterValues['category_id']) && $filterValues['category_id'] == $category->id ? ' selected' : '' ?>><?php echo $category->name ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="col-sm-3 form-group">
                <label for="filter_name">Name</label>
                <input name="filter[name]" id="filter_name" class="form-control" value="<?php echo isset($filterValues['name']) ? $filterValues['name'] : '' ?>">
            </div>
            <div class="col-sm-3 form-group">
                <label for="filter_description">Description</label>
                <input name="filter[description]" id="filter_description" class="form-control" value="<?php echo isset($filterValues['description']) ? $filterValues['description'] : '' ?>">
            </div>
            <div class="col-sm-3 form-group">
                <label for="filter_price">Price</label>
                <input name="filter[price]" id="filter_price" class="form-control" value="<?php echo isset($filterValues['price']) ? $filterValues['price'] : '' ?>">
            </div>
            <?php foreach ($attributes as $attr) : ?>
                <div class="col-sm-3 form-group">
                    <label for="filter_<?php echo $attr->code ?>" class="control-label"><?php echo $attr->name ?></label>
                    <?php if ($attr->attributeType == 'text' || $attr->attributeType == 'integer' || $attr->attributeType == 'decimal') : ?>
                        <input class="form-control" type="text" id="filter_<?php echo $attr->code ?>" name="filter[<?php echo $attr->code ?>]" value="<?php echo isset($filterValues[$attr->code]) ? $filterValues[$attr->code] : '' ?>">
                    <?php elseif ($attr->attributeType == 'select') : ?>
                        <select class="form-control" id="filter_<?php echo $attr->code ?>" name="filter[<?php echo $attr->code ?>]">
                            <option value=""<?php echo !isset($filterValues[$attr->code]) || !$filterValues[$attr->code] ? ' selected' : '' ?>>Any</option>
                            <?php foreach ($attr->getChoices() as $value => $label) : ?>
                                <option value="<?php echo $value ?>"<?php echo isset($filterValues[$attr->code]) && $filterValues[$attr->code] == $value ? ' selected' : '' ?>><?php echo $label ?></option>
                            <?php endforeach ?>
                        </select>
                    <?php endif ?>
                </div>
            <?php endforeach ?>
        </div>
        <button type="submit" class="btn btn-primary">Apply</button>
        <button type="button" class="btn btn-default" onclick="resetFilter();">Reset</button>
        <br>
    </form>
</div>
<script>
    function resetFilter() {
        $('#form-filter').find('select, input:text').each(function() {
            $(this).val('');
        });
        $('#form-filter').submit();
    }
</script>