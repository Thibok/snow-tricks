<?php

/**
 * ImageUploader Test
 */

namespace Tests\AppBundle\Uploader;

use PHPUnit\Framework\TestCase;
use AppBundle\Uploader\ImageUploader;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * ImageUploaderTest
 * @coversDefaultClass \AppBundle\Uploader\ImageUploader
 */
class ImageUploaderTest extends TestCase
{
    /**
     * Test upload method of ImageUploader
     * @access public
     * @covers ::upload
     *
     * @return void
     */
    public function testUpload()
    {
        $fileDir = __DIR__.'/../../../tests/AppBundle/uploads/';

        copy($fileDir.'userimage.png', $fileDir.'userimage-copy.png');
        $file = new UploadedFile(
            __DIR__.'/../../../tests/AppBundle/uploads/userimage-copy.png',
            'userimage.png',
            'image/png',
            null,
            null,
            true
        );

        $uploader = new ImageUploader('test');
        $filename = $uploader->upload($file);

        if (file_exists(ImageUploader::BASE_TEST_DIR.'/'.$filename)) {
            $result = true;
            unlink(ImageUploader::BASE_TEST_DIR.'/'.$filename);
        } else {
            $result = false;
        }

        $this->assertTrue($result);
    }

    /**
     * Test resize method of ImageUploader
     * @access public
     * @covers ::resize
     *
     * @return void
     */
    public function testResize()
    {
        $fileDir = __DIR__.'/../../../tests/AppBundle/uploads/userimage.png';
        $destDir = ImageUploader::BASE_TEST_DIR.'/userimage.png';

        copy($fileDir, $destDir);

        $uploader = new ImageUploader('test');

        $uploader->resize('userimage.png', 200, 200);
        $imagesize = getimagesize($destDir);

        $this->assertSame(200, $imagesize[0]);
        $this->assertSame(200, $imagesize[1]);

        unlink($destDir);

    }

    /**
     * Test remove method of ImageUploader
     * @access public
     * @covers ::remove
     *
     * @return void
     */
    public function testRemove()
    {
        $fileDir = __DIR__.'/../../../tests/AppBundle/uploads/userimage.png';
        $destDir = ImageUploader::BASE_TEST_DIR.'/userimage.png';

        copy($fileDir, $destDir);

        $uploader = new ImageUploader('test');

        $uploader->remove('userimage.png');

        if (file_exists($destDir)) {
            $result = false;
        } else {
            $result = true;
        }

        $this->assertTrue($result);
    }
}