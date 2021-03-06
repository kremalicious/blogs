<?php

/**
 * ======================================================================
 * LICENSE: This file is subject to the terms and conditions defined in *
 * file 'license.txt', which is part of this source code package.       *
 * ======================================================================
 */

/**
 * Redirect manager
 * 
 * @package AAM
 * @author Vasyl Martyniuk <vasyl@vasyltech.com>
 */
class AAM_Backend_Feature_Redirect extends AAM_Backend_Feature_Abstract {
    
    /**
     * 
     */
    public function save() {
        $param   = AAM_Core_Request::post('param');
        $value   = AAM_Core_Request::post('value');
        $subject = AAM_Backend_View::getSubject();
        
        if ($this->isDefault()) {
            AAM_Core_Config::set($param, $value);
        } else {
            do_action('aam-action-redirect-save', $subject, $param, $value);
        }
        
        return json_encode(array('status' => 'success'));
    }
    
    /**
     * 
     * @return type
     */
    public function reset() {
        do_action('aam-action-redirect-reset', AAM_Backend_View::getSubject());
        
        return json_encode(array('status' => 'success')); 
    }
    
    /**
     * 
     * @return type
     */
    public function isDefault() {
        return AAM_Backend_View::getSubject()->getUID() == 'default';
    }
    
    /**
     * 
     * @param type $option
     * @return type
     */
    public function getOption($option, $default = null) {
        $value = AAM_Core_Config::get($option, $default);
        
        if (!$this->isDefault()) {
            $subject = AAM_Backend_View::getSubject();
            $value = apply_filters(
                    'aam-filter-redirect-option', $value, $option, $subject
            );
        }
        
        return $value;
    }
    
    /**
     * @inheritdoc
     */
    public static function getAccessOption() {
        return 'feature.redirect.capability';
    }
    
    /**
     * @inheritdoc
     */
    public static function getTemplate() {
        return 'object/redirect.phtml';
    }
    
    /**
     * Register Contact/Hire feature
     * 
     * @return void
     * 
     * @access public
     */
    public static function register() {
        $cap = AAM_Core_Config::get(self::getAccessOption(), 'administrator');
        
        AAM_Backend_Feature::registerFeature((object) array(
            'uid'        => 'redirect',
            'position'   => 30,
            'title'      => __('Access Denied Redirect', AAM_KEY),
            'capability' => $cap,
            'subjects'   => array(
                'AAM_Core_Subject_Role', 
                'AAM_Core_Subject_User', 
                'AAM_Core_Subject_Visitor',
                'AAM_Core_Subject_Default'
            ),
            'view'       => __CLASS__
        ));
    }

}