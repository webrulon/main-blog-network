<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Services_Trackback_SpamCheck_Wordlist.
 *
 * This spam detection module for Services_Trackback searches a given trackback
 * for word matches.
 *
 * PHP versions 4 and 5
 *
 * LICENSE: This source file is subject to version 3.0 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_0.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category  Webservices
 * @package   Trackback
 * @author    Tobias Schlitt <toby@php.net>
 * @copyright 2005-2006 The PHP Group
 * @license   http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version   CVS: $Id: Wordlist.php,v 1.10 2008/08/06 05:58:28 clockwerx Exp $
 * @link      http://pear.php.net/package/Services_Trackback
 * @since     File available since Release 0.5.0
 */

    // {{{ require_once

/**
 * Load PEAR error handling
 */
require_once 'PEAR.php';

/**
 * Load SpamCheck base class
 */

require_once 'Services/Trackback/SpamCheck.php';

    // }}}

/**
 * Wordlist
 * Module for spam detecion using a word list.
 *
 * @category  Webservices
 * @package   Trackback
 * @author    Tobias Schlitt <toby@php.net>
 * @copyright 2005-2006 The PHP Group
 * @license   http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version   Release: 0.6.2
 * @link      http://pear.php.net/package/Services_Trackback
 * @since     0.5.0
 * @access    public
 */
class Services_Trackback_SpamCheck_Wordlist extends Services_Trackback_SpamCheck
{

    // {{{ _options

    /**
     * Options for the Wordlist.
     *
     * @var array
     * @since 0.5.0
     * @access protected
     */
    var $_options = array(
        'continuous'    => false,
        'sources'       => array(
            'acne',
            'adipex',
            'anal',
            'blackjack',
            'cash',
            'casino',
            'cigar',
            'closet',
            'daystore',
            'diet',
            'drugs',
            'erection',
            'fundslender',
            'gambling',
            'hire',
            'hydrocodone',
            'investing',
            'lasik',
            'loan',
            'mattress',
            'mortgage',
            'naproxen',
            'neurontin',
            'payday',
            'penis',
            'pharma',
            'phentermine',
            'poker',
            'porn',
            'rheuma',
            'roulette',
            'sadism',
            'sex',
            'smoking',
            'texas hold',
            'tramadol',
            'uxury',
            'viagra',
            'vioxx',
            'weight loss',
            'xanax',
            'zantac',
        ),
        'elements'      => array(
            'title',
            'excerpt',
            'blog_name',
        ),
        'comparefunc' => array('Services_Trackback_SpamCheck_Wordlist', '_stripos'),
        'minmatches'    => 1,
    );

    // }}}
    // {{{ Services_Trackback_SpamCheck_Wordlist()

    /**
     * Constructor.
     * Create a new instance of the Wordlist spam protection module.
     *
     * @param array $options An array of options for this spam protection module.
     *                       General options are
     *                       'continuous':  Whether to continue checking more sources
     *                                      if a match has been found.
     *                       'sources':     List of blacklist servers. Indexed.
     *                       'comparefunc': A compare function callback with
     *                                      parameters $haystack, $needle (like
     *                                      'stripos').
     *                       'minmatches':  How many words have to be found to
     *                                      consider spam.
     *
     * @since 0.5.0
     * @access public
     * @return Services_Trackback_SpamCheck_WordList The newly created object.
     */
    function Services_Trackback_SpamCheck_Wordlist($options = null)
    {
        if (is_array($options)) {
            foreach ($options as $key => $val) {
                $this->_options[$key] = $val;
            }
        }
    }

    // }}}
    // {{{ check()

    /**
     * Check for spam using this module.
     * This method is utilized by a Services_Trackback object to check for spam.
     * Generally this method may not be overwritten, but it can be, if necessary.
     * This method calls the _checkSource() method for each source defined in the
     * $_options array (depending on the 'continuous' option), saves the
     * results and returns the spam status determined by the check.
     *
     * @param Services_Trackback $trackback The trackback to check.
     *
     * @since 0.5.0
     * @access public
     * @return bool Whether the checked object is spam or not.
     */
    function check($trackback)
    {
        $spamCount = 0;
        foreach (array_keys($this->_options['sources']) as $id) {
            if ($spamCount >= $this->_options['minmatches']
                && !$this->_options['continuous']) {
                // We already found spam and shall not continue
                $this->_results[$id] = false;
            } else {
                $res = $this->_checkSource($this->_options['sources'][$id],
                                           $trackback);

                $spamCount += ($res === true) ? 1 : 0;

                $this->_results[$id] = $res;
            }
        }
        return ($spamCount >= $this->_options['minmatches']);
    }

    // }}}
    // {{{ _checkSource()

    /**
     * Check a specific source if a trackback has to be considered spam.
     *
     * @param mixed              $source    Element of the _sources array to check.
     * @param Services_Trackback $trackback The trackback to check.
     *
     * @since 0.5.0
     * @access protected
     * @return bool True if trackback is spam, false, if not, PEAR_Error on error.
     */
    function _checkSource($source, $trackback)
    {
        $spam = false;
        foreach ($this->_options['elements'] as $element) {
            $elements[$element] = html_entity_decode($trackback->get($element));
        }
        foreach ($elements as $element) {
            $result = call_user_func($this->_options['comparefunc'], $source,
                                     $element);
            if (false !== $result) {
                $spam = true;
                break;
            }
        }
        return $spam;
    }

    // }}}
    // {{{ _stripos()

    /**
     * Checks source text for an element, regardless of case.
     *
     * @param string $source  Source text
     * @param string $element Element text
     *
     * @return int
     */
    function _stripos($source, $element)
    {
        return strpos(strtolower($element), strtolower($source));
    }

    // }}}

}
