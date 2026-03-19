<?php
class Logger {
    private $log_file;
    private $log_level;

    public function __construct($log_file = null, $log_level = 'INFO') {
        $this->log_file = $log_file ?: __DIR__ . '/../../logs/app.log';
        $this->log_level = $log_level;

        // Criar diretório de logs se não existir
        $log_dir = dirname($this->log_file);
        if (!file_exists($log_dir)) {
            mkdir($log_dir, 0755, true);
        }
    }

    public function info($message) {
        $this->log('INFO', $message);
    }

    public function warning($message) {
        $this->log('WARNING', $message);
    }

    public function error($message) {
        $this->log('ERROR', $message);
    }

    public function debug($message) {
        $this->log('DEBUG', $message);
    }

    private function log($level, $message) {
        if ($this->shouldLog($level)) {
            $timestamp = date('Y-m-d H:i:s');
            $ip = $this->getClientIP();
            $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';

            $log_entry = "[{$timestamp}] {$level}: {$message} | IP: {$ip} | UA: {$user_agent}" . PHP_EOL;

            file_put_contents($this->log_file, $log_entry, FILE_APPEND | LOCK_EX);
        }
    }

    private function shouldLog($level) {
        $levels = ['DEBUG' => 0, 'INFO' => 1, 'WARNING' => 2, 'ERROR' => 3];
        return $levels[$level] >= $levels[$this->log_level];
    }

    private function getClientIP() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            return $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
        }
    }
}
?>
