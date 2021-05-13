<?php

namespace Src;

use Lib\CliPrinter;

class Passgen {
    protected $printer;
    protected $registry = [];

    public function __construct() {
        $this->printer = new CliPrinter();
    }

    public function getPrinter() {
        return $this->printer;
    }

    public function registerCommand($name, $callable) {
        $this->registry[$name] = $callable;
    }

    public function getCommand($command) {
        return $this->registry[$command] ?? null;
    }

    public function runCommand(array $argv) {
        $command_name = "help";

        if (isset($argv[1])) {
            $command_name = $argv[1];
        }

        $command = $this->getCommand($command_name);

        if ($command === null) {
            $this->getPrinter()->display("ERROR: Command \"$command_name\" not found.");
            exit;
        }

        call_user_func($command, $argv);
    }

    public function generate(int $length) {
        if (isset($length)) {
            $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!"#$%&\'()*+,-./:;<=>?@[\]^_`{|}~';
            $charactersLength = strlen($characters) - 1;
            $password = [];

            for ($i = 0; $i < $length; ++$i) {
                $key = rand(0, $charactersLength);
                $password[] = $characters[$key];
            }
            
            $this->getPrinter()->display(implode($password));
        }
    }
}
