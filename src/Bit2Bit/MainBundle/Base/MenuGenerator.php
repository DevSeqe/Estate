<?php

namespace Bit2Bit\MainBundle\Base;

class MenuGenerator {

    private $menu = array();
    private $roles;

    public function __construct($user) {
        $this->roles = $user->getRoles();
    }

    public function add($name, $route, $icon = '', $required_role = false, $badge = false) {
        if (!$required_role) {
            $this->menu[] = array(
                'route' => $route,
                'name' => $name,
                'icon' => $icon,
                'badge' => $badge
            );
        } else {
            if (in_array($required_role, $this->roles)) {
                $this->menu[] = array(
                    'route' => $route,
                    'name' => $name,
                    'icon' => $icon,
                    'badge' => $badge
                );
            }
        }
        return $this;
    }
    
    public function getMenu(){
        return $this->menu;
    }

}
