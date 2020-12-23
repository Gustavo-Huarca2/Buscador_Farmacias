<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Product Entity
 *
 * @property int $id
 * @property string $name
 * @property float $price
 * @property int $amount
 * @property int $pharmacy_id
 * @property string $mark
 * @property string $Type
 * @property \Cake\I18n\FrozenDate $due_date
 * @property int $presentation
 *
 * @property \App\Model\Entity\Pharmacy $pharmacy
 */
class Product extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'name' => true,
        'price' => true,
        'amount' => true,
        'pharmacy_id' => true,
        'mark' => true,
        'Type' => true,
        'due_date' => true,
        'presentation' => true,
        'pharmacy' => true,
    ];
}
