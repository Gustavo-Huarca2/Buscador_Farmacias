<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Pharmacy;
use Authorization\IdentityInterface;

/**
 * Pharmacy policy
 */
class PharmacyPolicy
{
         /**
     * Check if $user can add User
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\User $resource
     * @return bool
     */
    public function canIndex(IdentityInterface $user, Pharmacy $pharmacy)
    {
        
        return $user['rol_id']==1   ||   $user['rol_id']==3;
    }





    /**
     * Check if $user can add Pharmacy
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Pharmacy $pharmacy
     * @return bool
     */
    public function canAdd(IdentityInterface $user, Pharmacy $pharmacy)
    {
        return $user['rol_id']==1   ||   $user['rol_id']==3;
    }

    /**
     * Check if $user can edit Pharmacy
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Pharmacy $pharmacy
     * @return bool
     */
    public function canEdit(IdentityInterface $user, Pharmacy $pharmacy)
    {
        return $user['rol_id']==1   ||   $user['rol_id']==3;
    }

    /**
     * Check if $user can delete Pharmacy
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Pharmacy $pharmacy
     * @return bool
     */
    public function canDelete(IdentityInterface $user, Pharmacy $pharmacy)
    {
        return $user['rol_id']==1;
    }

    /**
     * Check if $user can view Pharmacy
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Pharmacy $pharmacy
     * @return bool
     */
    public function canView(IdentityInterface $user, Pharmacy $pharmacy)
    {
        return $user['rol_id']==1   ||   $user['rol_id']==3;;
    }
}
