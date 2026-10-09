<?php
/**
 * @author      Binh Nguyen! Project
 * @package     giaiphapcongnghethongtin.Site
 * @subpackage  mod_smartmenus
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

$id = '';

if ($tagId = $params->get('tag_id', '')) {
    $id = ' id="' . $tagId . '"';
}

// The menu class is deprecated. Use nav instead
?>
<!-- Left nav -->
<ul class="navbar-nav mr-auto <?php echo $class_sfx; ?> <?php echo $justify_content; ?> <?php echo $direction; ?>"<?php echo $id; ?>>
    <li class="nav-item"><a class="nav-link" href="#">Link</a></li>
    <li class="nav-item"><a class="nav-link" href="#">Link</a></li>
    <li class="nav-item"><a class="nav-link" href="#">Link</a></li>
    <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#">Dropdown</a>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item disabled" href="#">Disabled link</a></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
            <li class="dropdown-divider"></li>
            <li class="dropdown-header">Nav header</li>
            <li><a class="dropdown-item" href="#">Separated link</a></li>

            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
            <li><a class="dropdown-item" href="#">One more link</a></li>
            <li><a class="dropdown-item" href="#">Menu item 1</a></li>
            <li><a class="dropdown-item" href="#">Menu item 2</a></li>
            <li><a class="dropdown-item" href="#">Menu item 3</a></li>
            <li><a class="dropdown-item" href="#">Menu item 4</a></li>
            <li><a class="dropdown-item" href="#">Menu item 5</a></li>
            <li><a class="dropdown-item" href="#">Menu item 6</a></li>
            <li><a class="dropdown-item" href="#">Menu item 7</a></li>
            <li><a class="dropdown-item" href="#">Menu item 8</a></li>
            <li><a class="dropdown-item" href="#">Menu item 9</a></li>
            <li><a class="dropdown-item" href="#">Menu item 10</a></li>
            <li><a class="dropdown-item" href="#">Menu item 11</a></li>
            <li><a class="dropdown-item" href="#">Menu item 12</a></li>
            <li><a class="dropdown-item" href="#">Menu item 13</a></li>
            <li><a class="dropdown-item" href="#">Menu item 14</a></li>
            <li><a class="dropdown-item" href="#">Menu item 15</a></li>
            <li><a class="dropdown-item" href="#">Menu item 16</a></li>
            <li><a class="dropdown-item" href="#">Menu item 17</a></li>
            <li><a class="dropdown-item" href="#">Menu item 18</a></li>
            <li><a class="dropdown-item" href="#">Menu item 19</a></li>
            <li><a class="dropdown-item" href="#">Menu item 20</a></li>
            <li><a class="dropdown-item" href="#">Menu item 21</a></li>
            <li><a class="dropdown-item" href="#">Menu item 22</a></li>
            <li><a class="dropdown-item" href="#">Menu item 23</a></li>
            <li><a class="dropdown-item" href="#">Menu item 24</a></li>
            <li><a class="dropdown-item" href="#">Menu item 25</a></li>
            <li><a class="dropdown-item" href="#">Menu item 26</a></li>
            <li><a class="dropdown-item" href="#">Menu item 27</a></li>
            <li><a class="dropdown-item" href="#">Menu item 28</a></li>
            <li><a class="dropdown-item" href="#">Menu item 29</a></li>
            <li><a class="dropdown-item" href="#">Menu item 30</a></li>
            <li><a class="dropdown-item" href="#">Menu item 31</a></li>
            <li><a class="dropdown-item" href="#">Menu item 32</a></li>
            <li><a class="dropdown-item" href="#">Menu item 33</a></li>
            <li><a class="dropdown-item" href="#">Menu item 34</a></li>
            <li><a class="dropdown-item" href="#">Menu item 35</a></li>
            <li><a class="dropdown-item" href="#">Menu item 36</a></li>
            <li><a class="dropdown-item" href="#">Menu item 37</a></li>
            <li><a class="dropdown-item" href="#">Menu item 38</a></li>
            <li><a class="dropdown-item" href="#">Menu item 39</a></li>
            <li><a class="dropdown-item" href="#">Menu item 40</a></li>
            <li><a class="dropdown-item" href="#">Menu item 41</a></li>
            <li><a class="dropdown-item" href="#">Menu item 42</a></li>
            <li><a class="dropdown-item" href="#">Menu item 43</a></li>
            <li><a class="dropdown-item" href="#">Menu item 44</a></li>
            <li><a class="dropdown-item" href="#">Menu item 45</a></li>
            <li><a class="dropdown-item" href="#">Menu item 46</a></li>
            <li><a class="dropdown-item" href="#">Menu item 47</a></li>
            <li><a class="dropdown-item" href="#">Menu item 48</a></li>
            <li><a class="dropdown-item" href="#">Menu item 49</a></li>
            <li><a class="dropdown-item" href="#">Menu item 50</a></li>
            <li><a class="dropdown-item" href="#">Menu item 51</a></li>
            <li><a class="dropdown-item" href="#">Menu item 52</a></li>
            <li><a class="dropdown-item" href="#">Menu item 53</a></li>
            <li><a class="dropdown-item" href="#">Menu item 54</a></li>
            <li><a class="dropdown-item" href="#">Menu item 55</a></li>
            <li><a class="dropdown-item" href="#">Menu item 56</a></li>
            <li><a class="dropdown-item" href="#">Menu item 57</a></li>
            <li><a class="dropdown-item" href="#">Menu item 58</a></li>
            <li><a class="dropdown-item" href="#">Menu item 59</a></li>
            <li><a class="dropdown-item" href="#">Menu item 60</a></li>

            <li class="dropdown"><a class="dropdown-item dropdown-toggle" href="#">One more separated link</a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li class="dropdown"><a class="dropdown-item dropdown-toggle" href="#">A long sub menu</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                            <li><a class="dropdown-item" href="#">One more link</a></li>
                            <li><a class="dropdown-item" href="#">Menu item 1</a></li>
                            <li><a class="dropdown-item" href="#">Menu item 2</a></li>
                            <li><a class="dropdown-item" href="#">Menu item 3</a></li>
                            <li><a class="dropdown-item" href="#">Menu item 4</a></li>
                            <li><a class="dropdown-item" href="#">Menu item 5</a></li>
                            <li><a class="dropdown-item" href="#">Menu item 6</a></li>
                            <li><a class="dropdown-item" href="#">Menu item 7</a></li>
                            <li><a class="dropdown-item" href="#">Menu item 8</a></li>
                            <li><a class="dropdown-item" href="#">Menu item 9</a></li>
                            <li><a class="dropdown-item" href="#">Menu item 10</a></li>
                            <li><a class="dropdown-item" href="#">Menu item 11</a></li>
                            <li><a class="dropdown-item" href="#">Menu item 12</a></li>
                            <li><a class="dropdown-item" href="#">Menu item 13</a></li>
                            <li><a class="dropdown-item" href="#">Menu item 14</a></li>
                            <li><a class="dropdown-item" href="#">Menu item 15</a></li>
                            <li><a class="dropdown-item" href="#">Menu item 16</a></li>
                            <li><a class="dropdown-item" href="#">Menu item 17</a></li>
                            <li><a class="dropdown-item" href="#">Menu item 18</a></li>
                            <li><a class="dropdown-item" href="#">Menu item 19</a></li>
                            <li><a class="dropdown-item" href="#">Menu item 20</a></li>
                            <li><a class="dropdown-item" href="#">Menu item 21</a></li>
                            <li><a class="dropdown-item" href="#">Menu item 22</a></li>
                            <li><a class="dropdown-item" href="#">Menu item 23</a></li>
                            <li><a class="dropdown-item" href="#">Menu item 24</a></li>
                            <li><a class="dropdown-item" href="#">Menu item 25</a></li>
                            <li><a class="dropdown-item" href="#">Menu item 26</a></li>
                            <li><a class="dropdown-item" href="#">Menu item 27</a></li>
                            <li><a class="dropdown-item" href="#">Menu item 28</a></li>
                            <li><a class="dropdown-item" href="#">Menu item 29</a></li>
                            <li><a class="dropdown-item" href="#">Menu item 30</a></li>
                            <li><a class="dropdown-item" href="#">Menu item 31</a></li>
                            <li><a class="dropdown-item" href="#">Menu item 32</a></li>
                            <li><a class="dropdown-item" href="#">Menu item 33</a></li>
                            <li><a class="dropdown-item" href="#">Menu item 34</a></li>
                            <li><a class="dropdown-item" href="#">Menu item 35</a></li>
                            <li><a class="dropdown-item" href="#">Menu item 36</a></li>
                            <li><a class="dropdown-item" href="#">Menu item 37</a></li>
                            <li><a class="dropdown-item" href="#">Menu item 38</a></li>
                            <li><a class="dropdown-item" href="#">Menu item 39</a></li>
                            <li><a class="dropdown-item" href="#">Menu item 40</a></li>
                            <li><a class="dropdown-item" href="#">Menu item 41</a></li>
                            <li><a class="dropdown-item" href="#">Menu item 42</a></li>
                            <li><a class="dropdown-item" href="#">Menu item 43</a></li>
                            <li><a class="dropdown-item" href="#">Menu item 44</a></li>
                            <li><a class="dropdown-item" href="#">Menu item 45</a></li>
                            <li><a class="dropdown-item" href="#">Menu item 46</a></li>
                            <li><a class="dropdown-item" href="#">Menu item 47</a></li>
                            <li><a class="dropdown-item" href="#">Menu item 48</a></li>
                            <li><a class="dropdown-item" href="#">Menu item 49</a></li>
                            <li><a class="dropdown-item" href="#">Menu item 50</a></li>
                            <li><a class="dropdown-item" href="#">Menu item 51</a></li>
                            <li><a class="dropdown-item" href="#">Menu item 52</a></li>
                            <li><a class="dropdown-item" href="#">Menu item 53</a></li>
                            <li><a class="dropdown-item" href="#">Menu item 54</a></li>
                            <li><a class="dropdown-item" href="#">Menu item 55</a></li>
                            <li><a class="dropdown-item" href="#">Menu item 56</a></li>
                            <li><a class="dropdown-item" href="#">Menu item 57</a></li>
                            <li><a class="dropdown-item" href="#">Menu item 58</a></li>
                            <li><a class="dropdown-item" href="#">Menu item 59</a></li>
                            <li><a class="dropdown-item" href="#">Menu item 60</a></li>
                        </ul>
                    </li>
                    <li><a class="dropdown-item" href="#">Another link</a></li>
                    <li><a class="dropdown-item" href="#">One more link</a></li>
                </ul>
            </li>
        </ul>
    </li>
</ul>

<!-- Right nav -->
<ul class="nav navbar-nav">
    <li class="nav-item"><a class="nav-link" href="bootstrap-4-navbar.html">Default</a></li>
    <li class="nav-item"><a class="nav-link" href="bootstrap-4-navbar-static-top.html">Static top</a></li>
    <li class="nav-item active"><a class="nav-link" href="bootstrap-4-navbar-fixed-top.html">Fixed top</a></li>
    <li class="nav-item"><a class="nav-link" href="bootstrap-4-navbar-fixed-bottom.html">Fixed bottom</a></li>
    <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#">Dropdown</a>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
            <li class="dropdown-divider"></li>
            <li class="dropdown-header">Nav header</li>
            <li class="dropdown"><a class="dropdown-item dropdown-toggle" href="#">A sub menu</a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                    <li><a class="dropdown-item disabled" href="#">Disabled item</a></li>
                    <li><a class="dropdown-item" href="#">One more link</a></li>
                </ul>
            </li>
            <li><a class="dropdown-item" href="#">A separated link</a></li>
        </ul>
    </li>
</ul>
