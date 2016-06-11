<?php
/**
 * Query Log plugin for Craft CMS
 *
 * Query Log Variable
 *
 * @author    Rob Sanchez
 * @copyright Copyright (c) 2016 Rob Sanchez
 * @link      https://github.com/rsanchez
 * @package   QueryLog
 * @since     1.0.0
 */

namespace Craft;

use CLogger;
use ReflectionProperty;

class QueryLogVariable
{
    /**
     */
    public function queries()
    {
        $logs = Craft::getLogger()->getLogs(CLogger::LEVEL_PROFILE, 'system.db.CDbCommand.query');

        $queries = array();

        $startTimes = array();

        foreach ($logs as $log) {
            $msg = $log[0];
            $time = $log[3];
            $query = new \stdClass();

            if (strpos($msg, 'begin:') === 0) {
                $sql = substr($msg, 6 + 27, -1);
                $startTimes[$sql] = $time;
            } elseif (strpos($msg, 'end:') === 0) {
                $query->sql = $this->parseSqlBindings(substr($msg, 4 + 27, -1));
                $query->duration = number_format(($time - $startTimes[$sql]) * 1000, 2).'ms';
                $queries[] = $query;
            }
        }

        return $queries;
    }

    public function __toString()
    {
        $this->hackAddTemplatePath();

        $queries = $this->queries();

        if (!$queries) {
            return '';
        }

        return craft()->templates->render('querylog/index', compact('queries'));
    }

    /**
     * Parse a sql statement and interpolate any bindings
     * @param  string $sql
     * @return string
     */
    protected function parseSqlBindings($query)
    {
        if (preg_match('/^(.*?)\. Bound with (.*?)$/s', $query, $match)) {
            $query = $match[1];
            $bindings = $match[2];

            preg_match_all('/:(.*?)=(.*?)(,|$)/', $bindings, $matches);

            foreach ($matches[1] as $i => $column) {
                $value = $matches[2][$i];

                $query = str_replace(':'.$column, $value, $query);
            }
        }

        return $query.';';
    }

    /**
     * Template service doesn't normally let you load plugin templates on a non CP/ non action request
     * So we inject our querylog/index template path here
     * @return void
     */
    protected function hackAddTemplatePath()
    {
        // add our template path
        $key = craft()->path->getSiteTemplatesPath().':querylog/index';

        $path = craft()->path->getPluginsPath().'querylog/templates/index.twig';

        $reflectionProperty = new ReflectionProperty(craft()->templates, '_templatePaths');

        $reflectionProperty->setAccessible(true);

        $templatePaths = $reflectionProperty->getValue(craft()->templates);

        $templatePaths[$key] = $path;

        $reflectionProperty->setValue(craft()->templates, $templatePaths);

        $reflectionProperty->setAccessible(false);
    }
}
