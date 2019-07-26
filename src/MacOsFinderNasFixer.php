<?php

namespace gan068;

class MacOsFinderNasFixer
{
    protected $target_time_str = '1984-01-24 16:00:00';

    public function setTargetTimeStr($value)
    {
        $this->target_time_str = $value;
    }
    public function getTargetTimeStr()
    {
        return $this->target_time_str;
    }
    protected function replaceBirthtime($file_name, $target_time_str)
    {
        $btime = 0;
        $stat = stat($file_name);
        $ctime_str = date('m/d/Y H:i:s', $stat['ctime']);
        if ($handle = popen('stat -f %B ' . escapeshellarg($file_name), 'r')) {
            $btime = trim(fread($handle, 100));
            $target_time = strtotime($target_time_str);

            pclose($handle);
            if ($btime == $target_time) {
                echo $ctime_str . PHP_EOL;
                echo $file_name . PHP_EOL;
                exec("SetFile -d \"{$ctime_str}\" \"{$file_name}\"");
            }
        }
    }
    public function travelDir(String $dir)
    {
        if ($dir_source = opendir($dir)) {
            while (($item = readdir($dir_source)) !== false) {
                $file_name = "{$dir}/{$item}";
                if ($item == "." || $item == "..") {
                    continue;
                }
                $this->replaceBirthtime($file_name, $this->getTargetTimeStr());
                if (is_dir($file_name)) {
                    travelDir($file_name);
                }
            }
            closedir($dir_source);
        }
    }
}
