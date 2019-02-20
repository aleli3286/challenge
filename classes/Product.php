<?php
/**
 * Created by PhpStorm.
 * Date: 2/19/2019
 * Time: 10:30 AM
 */

namespace App\Entity;

use App\Kernel\Container;
use App\Model\AttributeHolder;
use App\Model\CustomAttribute;

class Product
{
    public $id;
    public $name;
    public $description;
    public $image;
    public $price;
    public $categoryId;

    private $attributeHolder;
    private $category;

    public function __construct()
    {
        $this->attributeHolder = new AttributeHolder();
    }

    public function setCategory(Category $category)
    {
        $this->category = $category;
        $this->categoryId = $category->id;

        return $this;
    }

    public function getCategory()
    {
        if ((null === $this->category) && (null !== $this->categoryId)) {
            $this->category = Container::getInstance()->get('category')->findOneBy(['id' => $this->categoryId]);

            if (null === $this->category) {
                throw new \RuntimeException('Entity does not exists!');
            }
        }

        return $this->category;
    }

    /**
     * @param CustomAttribute $customAttribute
     */
    public function setCustomAttribute(CustomAttribute $customAttribute)
    {
        $this->attributeHolder->setData($customAttribute->getAttribute()->code, $customAttribute);

        return $this;
    }

    /**
     * @param string $code
     * @return CustomAttribute
     */
    public function getCustomAttribute($code)
    {
        return $this->attributeHolder->getData($code);
    }
}