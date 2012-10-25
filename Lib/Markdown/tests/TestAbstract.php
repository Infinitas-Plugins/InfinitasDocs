<?php
/**
 * Common class for all tests.
 */

abstract class TestAbstract extends PHPUnit_Framework_TestCase
{
    /**
     * Searches for files based on current class name.
     *
     * @return array
     */
    public function filesystem()
    {
        $data = array();

        $classname = get_class($this);
        if (substr($classname, -4) == 'Test') {
            preg_match_all('/[A-Z][a-z]+/', substr($classname, 0, -4), $dir);
            $dir = __DIR__ . '/data/' . implode('/', $dir[0]);

            if (is_dir($dir) && is_readable($dir)) {
                foreach(glob($dir . '/*.text') as $markdown) {
                    if (is_dir($markdown)) continue;
                    $basename = basename($markdown);
                    $html     = $dir . '/' . substr($basename, 0, -5);
                    if (is_readable($html)) {
                        $data[] = array(
                            file_get_contents($markdown),
                            file_get_contents($html)
                        );
                    }
                }

            }
        }

        return $data;
    }
}