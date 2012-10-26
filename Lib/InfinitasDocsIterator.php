<?php
class InfinitasDocsIterator extends FilterIterator {
	public function accept() {
		return $this->current()->getExtension() == 'md';
	}
}