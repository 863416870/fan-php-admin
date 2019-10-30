<?php

namespace app\lib\file;

use think\facade\Config;
use app\common\model\File as CmsFile;
use app\lib\exception\file\FileException;
use app\lib\file\File;
use think\facade\Env;
/**
 * Class LocalUploader
 * @package app\lib\file
 */
class LocalUploader extends File
{
    /**
     * @return array
     * @throws FileException
     */
    public function upload()
    {
        $ret = [];
        $host = Config::get('file.host') ?? "http://127.0.0.1:8000";
        foreach ($this->files as $key => $file) {
            $md5 = $this->generateMd5($file);
            $exists = CmsFile::get(['md5' => $md5]);
            if ($exists) {
                array_push($ret, [
                    'id' => $exists['id'],
                    'key' => $key,
                    'path' => $exists['path'],
                    'url' => $host . '/' . $this->storeDir . '/' . $exists['path']
                ]);
            } else {
                $size = $this->getSize($file);
                $info = $file->move(Env::get('root_path') .'/'.'public' .'/'. $this->storeDir);
                if ($info) {
                    $extension = '.' . $info->getExtension();
                    $path = str_replace('\\','/',$info->getSaveName());
                    $name = $info->getFilename();
                } else {
                    throw new FileException([
                        'msg' => $this->getError,
                        'error_code' => 60001
                    ]);
                }
                $CmsFile = CmsFile::create([
                    'name' => $name,
                    'path' => $path,
                    'size' => $size,
                    'extension' => $extension,
                    'md5' => $md5,
                    'type' => 1
                ]);
                array_push($ret, [
                    'id' => $CmsFile->id,
                    'key' => $key,
                    'path' => $path,
                    'url' => $host . '/' . $this->storeDir . '/' . $path
                ]);

            }

        }
        return $ret;
    }
}
