<?php
/**
 * Query Log plugin for Craft CMS
 *
 * Log DB queries to the front-end with template variables.
 *
 * @author    Rob Sanchez
 * @copyright Copyright (c) 2016 Rob Sanchez
 * @link      https://github.com/rsanchez
 * @package   QueryLog
 * @since     1.0.0
 */

namespace Craft;

class QueryLogPlugin extends BasePlugin
{
    /**
     * @return mixed
     */
    public function init()
    {
    }

    /**
     * @return mixed
     */
    public function getName()
    {
         return Craft::t('Query Log');
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return Craft::t('Log DB queries to the front-end with template variables.');
    }

    /**
     * @return string
     */
    public function getDocumentationUrl()
    {
        return '';
    }

    /**
     * @return string
     */
    public function getReleaseFeedUrl()
    {
        return '';
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return '1.0.1';
    }

    /**
     * @return string
     */
    public function getSchemaVersion()
    {
        return '1.0.0';
    }

    /**
     * @return string
     */
    public function getDeveloper()
    {
        return 'Rob Sanchez';
    }

    /**
     * @return string
     */
    public function getDeveloperUrl()
    {
        return 'https://github.com/rsanchez';
    }

    /**
     * @return bool
     */
    public function hasCpSection()
    {
        return false;
    }

    /**
     */
    public function onBeforeInstall()
    {
    }

    /**
     */
    public function onAfterInstall()
    {
    }

    /**
     */
    public function onBeforeUninstall()
    {
    }

    /**
     */
    public function onAfterUninstall()
    {
    }
}