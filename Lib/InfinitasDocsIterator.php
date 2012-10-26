<?php
class InfinitasDocsIterator extends FilterIterator implements Countable {
/**
 * @brief internal cache of the number of items in the list
 *
 * @var integer
 */
    protected $_count = null;

/**
 * @brief only return items that have a .md extension
 *
 * @return boolean
 */
	public function accept() {
		return $this->current()->getExtension() == 'md';
	}

/**
 * @brief get the number of itmes that are in the set
 *
 * @return integer
 */
	public function count() {
		if($this->_count === null) {
			foreach ($this as $item) {
				$this->_count++;
			}
		}

		return $this->_count;
	}
	
}