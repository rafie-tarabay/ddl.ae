<?php

if ( ! function_exists('auto_link'))
{
    /**
     * Auto-linker
     *
     * Automatically links URL and Email addresses.
     * Note: There's a bit of extra code here to deal with
     * URLs or emails that end in a period. We'll strip these
     * off and add them after the link.
     *
     * @param    string    the string
     * @param    string    the type: email, url, or both
     * @param    bool    whether to create pop-up links
     * @return    string
     */
    function auto_link($str, $type = 'both', $popup = FALSE)
    {                                                             
        // Find and replace any URLs.
        //if ($type !== 'email' && preg_match_all('#(\w*://|www\.)[^\s()<>;]+\w#i', $str, $matches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER))
        //if ($type !== 'email' && preg_match_all('#(\w*://|www\.)[^\s()<>;]+\w#ui', $str, $matches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER)) // line changed

        if ($type !== 'email' && preg_match_all('#(\w*://|www\.)[^\s()<>;]+\w#i'.(UTF8_ENABLED ? 'u' : ''), $str, $matches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER))        
        {                         
            // Set our target HTML if using popup links.
            $target = ($popup) ? ' target="_blank"' : '';

            // We process the links in reverse order (last -> first) so that
            // the returned string offsets from preg_match_all() are not
            // moved as we add more HTML.
            foreach (array_reverse($matches) as $match)
            {
                // $match[0] is the matched string/link
                // $match[1] is either a protocol prefix or 'www.'
                //
                // With PREG_OFFSET_CAPTURE, both of the above is an array,
                // where the actual value is held in [0] and its offset at the [1] index.
                $a = '<a href="'.(strpos($match[1][0], '/') ? '' : 'http://').$match[0][0].'"'.$target.'>'.$match[0][0].'</a>';
                $str = substr_replace($str, $a, $match[0][1], strlen($match[0][0]));
            }
        }

        // Find and replace any emails.
        if ($type !== 'url' && preg_match_all('#([\w\.\-\+]+@[a-z0-9\-]+\.[a-z0-9\-\.]+[^[:punct:]\s])#i', $str, $matches, PREG_OFFSET_CAPTURE))
        {
            foreach (array_reverse($matches[0]) as $match)
            {
                if (filter_var($match[0], FILTER_VALIDATE_EMAIL) !== FALSE)
                {
                    $str = substr_replace($str, safe_mailto($match[0]), $match[1], strlen($match[0]));
                }
            }
        }

        return $str;
    }
}       