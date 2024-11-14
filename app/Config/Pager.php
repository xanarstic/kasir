<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Pager extends BaseConfig
{
	/**
	 * --------------------------------------------------------------------------
	 * Templates
	 * --------------------------------------------------------------------------
	 *
	 * Pagination links are rendered out using views to configure their
	 * appearance. This array contains aliases and the view names to
	 * use when rendering the links.
	 *
	 * Within each view, the Pager object will be available as $pager,
	 * and the desired group as $pagerGroup;
	 *
	 * @var array<string, string>
	 */
	public $templates = [
		'default_full' => 'CodeIgniter\Pager\Views\default_full',
		'default_simple' => 'CodeIgniter\Pager\Views\default_simple',
		'default_head' => 'CodeIgniter\Pager\Views\default_head',
	];
	public $bootstrap_pagination = [
		'full' => '<ul class="pagination justify-content-center">{first}{previous}{pages}{next}{last}</ul>',
		'first' => '<li class="page-item"><a class="page-link" href="{uri}">First</a></li>',
		'previous' => '<li class="page-item"><a class="page-link" href="{uri}" aria-label="Previous">&laquo;</a></li>',
		'next' => '<li class="page-item"><a class="page-link" href="{uri}" aria-label="Next">&raquo;</a></li>',
		'last' => '<li class="page-item"><a class="page-link" href="{uri}">Last</a></li>',
		'active' => '<li class="page-item active"><span class="page-link">{page}</span></li>',
		'inactive' => '<li class="page-item disabled"><span class="page-link">{page}</span></li>',
	];


	/**
	 * --------------------------------------------------------------------------
	 * Items Per Page
	 * --------------------------------------------------------------------------
	 *
	 * The default number of results shown in a single page.
	 *
	 * @var integer
	 */
	public $perPage = 20;
}
