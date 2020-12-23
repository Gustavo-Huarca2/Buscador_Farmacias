<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Pharmacy Entity
 *
 * @property int $id
 * @property string $name
 * @property int $user_id
 * @property string $address
 * @property bool $status
 * @property float $latitude
 * @property float $length
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Comment[] $comments
 * @property \App\Model\Entity\Product[] $products
 */
class Pharmacy extends Entity
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
        'user_id' => true,
        'address' => true,
        'status' => true,
        'latitude' => true,
        'length' => true,
        'user' => true,
        'comments' => true,
        'products' => true,
    ];
}
