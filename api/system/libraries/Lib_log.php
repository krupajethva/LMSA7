<?php

/**
 * CodeIgniter Log Library
 *
 * @category   Applications
 * @package    CodeIgniter
 * @subpackage Libraries
 * @author     Bo-Yi Wu <appleboy.tw@gmail.com>
 * @license    BSD License
 * @link       http://blog.wu-boy.com/
 * @since      Version 1.0
 * @link       https://github.com/appleboy/CodeIgniter-Log-Library
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class CI_Lib_log
{
    /**
     * ci
     *
     * @param instance object
     */
    private $_ci;
    /**
     * log table name
     *
     * @param string
     */
    private $_log_table_name;
    public $levels = array(
        E_ERROR             => 'Error',
        E_WARNING           => 'Warning',
        E_PARSE             => 'Parsing Error',
        E_NOTICE            => 'Notice',
        E_CORE_ERROR        => 'Core Error',
        E_CORE_WARNING      => 'Core Warning',
        E_COMPILE_ERROR     => 'Compile Error',
        E_COMPILE_WARNING   => 'Compile Warning',
        E_USER_ERROR        => 'User Error',
        E_USER_WARNING      => 'User Warning',
        E_USER_NOTICE       => 'User Notice',
        E_STRICT            => 'Runtime Notice',
        E_RECOVERABLE_ERROR => 'Catchable error',
        E_DEPRECATED        => 'Runtime Notice',
        E_USER_DEPRECATED   => 'User Warning'
    );
    /**
     * constructor
     *
     */
    public function __construct()
    {
        try {
            $this->_ci =& get_instance();
            set_error_handler(array($this, 'error_handler'));
            set_exception_handler(array($this, 'exception_handler'));
            // Load database driver
            //We are loading the database helper in autoload so no need to load them again here!
            //$this->_ci->load->database();
            
            // Load config file
            //$this->_ci->load->config('log');
            //Retrieve the table name from the $config array::
            $this->_log_table_name = ($this->_ci->config->item('log_table_name')) ? $this->_ci->config->item('log_table_name') : 'logs';
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    /**
     * PHP Error Handler
     *
     * @param   int
     * @param   string
     * @param   string
     * @param   int
     * @return void
     */
    public function error_handler($severity, $message, $filepath, $line)
    {
        try {
            $data = array(
            'errno' => $severity,
            'errtype' => isset($this->levels[$severity]) ? $this->levels[$severity] : $severity,
            'errstr' => $message,
            'errfile' => $filepath,
            'errline' => $line,
            'user_agent' => $this->_ci->input->user_agent(),
            'ip_address' => $this->_ci->input->ip_address(),
            'time' => date('Y-m-d H:i:s')
        );
        //echo $data['errstr'];
        log_message("error",  $data['errstr'] . " at line no ".$data['errline']. " in ".$data['errfile']);
        $this->_ci->db->insert($this->_log_table_name, $data);
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    /**
     * PHP Error Handler
     *
     * @param   object
     * @return void
     */
    public function exception_handler($exception)
    {
        try {
            $data = array(
            'errno' => $exception->getCode(),
            'errtype' => isset($this->levels[$exception->getCode()]) ? $this->levels[$exception->getCode()] : $exception->getCode(),
            'errstr' => $exception->getMessage(),
            'errfile' => $exception->getFile(),
            'errline' => $exception->getLine(),
            'user_agent' => $this->_ci->input->user_agent(),
            'ip_address' => $this->_ci->input->ip_address(),
            'time' => date('Y-m-d H:i:s')
        );
        //echo $data['errstr'];
        log_message("error",  $data['errstr'] . " at line no ".$data['errline']. " in ".$data['errfile']);
        $this->_ci->db->insert($this->_log_table_name, $data);
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
/* End of file Lib_log.php */