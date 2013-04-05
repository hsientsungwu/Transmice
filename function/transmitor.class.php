<?php

class Transmitor {

	private $sourceUrls = array();

	private $result = array();

	private $isExecutable = false; 

	private $internalPath = '';

	public function __construct($folder = null) {

		$tempFolder = ($folder) ? $folder : 'temp';

		$this->internalPath = $_SERVER['DOCUMENT_ROOT'] . '/transmitor/storage/' . $tempFolder . '/';
	}	

	public function execute() {
		if (!$this->isExecutable) return false;
		$result = array();

		foreach ($this->sourceUrls as $url) {
			$result[] = $this->getResource($url);
		}

		return $result;
	}

	protected function getResource($url) {
		$fileInfo = $this->getResourceName($url);

		if (is_array($fileInfo)) {
			if (copy($url, $this->internalPath . $fileInfo['fullname'])) {
				return array('success' => true, 'url' => $url);
			}
		}

		return array('success' => false, 'url' => $url);
	}

	protected function getResourceName($path) {
		$info = pathinfo($path);

		if (is_array($info)) {

			$fileInfo = array(
				'fullname' => $info['basename'],
				'extension' => $info['extension'],
				'filename' => $info['filename']
			);

			return $fileInfo;
		}

		return false;
	}

	public function setSourceUrls($sources) {
		if (is_array($sources) && count($sources)) {
			$this->sourceUrls = $sources;
			$this->isExecutable = true;
		}
	}

	public function getSourceUrls() {
		if (is_array($this->sourceUrls) && count($this->sourceUrls)) {
			return $this->sourceUrls;
		}

		return false;
	}
}