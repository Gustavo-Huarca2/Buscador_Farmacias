<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Comment Entity
 *
 * @property int $id
 * @property string $commentary
 * @property \Cake\I18n\FrozenTime $date
 * @property bool $state
 * @property int $user_id
 * @property int $pharmacy_id
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Pharmacy $pharmacy
 */
class Comment extends Entity
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
        'commentary' => true,
        'date' => true,
        'state' => true,
        'user_id' => true,
        'pharmacy_id' => true,
        'user' => true,
        'pharmacy' => true,
    ];
}
