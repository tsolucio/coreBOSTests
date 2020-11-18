<?php
/*************************************************************************************************
 * Copyright 2018 JPL TSolucio, S.L. -- This file is a part of TSOLUCIO coreBOS Tests.
 * The MIT License (MIT)
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software
 * and associated documentation files (the "Software"), to deal in the Software without restriction,
 * including without limitation the rights to use, copy, modify, merge, publish, distribute,
 * sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or
 * substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT
 * NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
 * IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
 * SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *************************************************************************************************/

use PHPUnit\Framework\TestCase;

include_once 'include/Webservices/GetRelatedRecords.php';
include_once 'include/Webservices/upsert.php';

class testWSgetRelatedRecords extends TestCase {

	/**
	 * Method getRelatedRecordsProvider
	 * params
	 */
	public function getRelatedRecordsProvider() {
		return array(
			array(
				'17x2636', 'HelpDesk', 'ModComments', array(
					'productDiscriminator'=>'',
					//'columns'=>'productname,product_no,id',
					'limit'=>'3',
					'offset'=>'0',
					'orderby'=>''
				),
				1, array(
					'records' => array(
						array(
							0 => '12x1098',
							'creator' => '12x1098',
							1 => '12x1098',
							'assigned_user_id' => '12x1098',
							2 => 'TicketComments',
							'setype' => 'TicketComments',
							3 => '2015-04-02 09:31:46',
							'createdtime' => '2015-04-02 09:31:46',
							4 => '2015-04-02 09:31:46',
							'modifiedtime' => '2015-04-02 09:31:46',
							5 => '0',
							'id' => '0',
							6 => 'mi. Aliquam gravida mauris ut mi. Duis risus odio, auctor vitae, aliquet nec, imperdiet nec, leo. Morbi neque tellus, imperdiet non, vestibulum nec, euismod in, dolor. Fusce feugiat. Lorem ipsum dolor sit amet,',
							'commentcontent' => 'mi. Aliquam gravida mauris ut mi. Duis risus odio, auctor vitae, aliquet nec, imperdiet nec, leo. Morbi neque tellus, imperdiet non, vestibulum nec, euismod in, dolor. Fusce feugiat. Lorem ipsum dolor sit amet,',
							7 => '17x2636',
							'related_to' => '17x2636',
							8 => '',
							'parent_comments' => '',
							9 => 'customer',
							'ownertype' => 'customer',
							10 => '',
							'owner_name' => '',
							11 => '',
							'owner_firstname' => '',
							12 => '',
							'owner_lastname' => '',
							13 => '',
							'creator_name' => '',
							14 => '',
							'creator_firstname' => '',
							15 => '',
							'creator_lastname' => '',
						),
						array(
							0 => '19x11',
							'creator' => '19x11',
							1 => '19x11',
							'assigned_user_id' => '19x11',
							2 => 'TicketComments',
							'setype' => 'TicketComments',
							3 => '2015-06-20 07:43:22',
							'createdtime' => '2015-06-20 07:43:22',
							4 => '2015-06-20 07:43:22',
							'modifiedtime' => '2015-06-20 07:43:22',
							5 => '0',
							'id' => '0',
							6 => 'ac metus vitae velit egestas lacinia. Sed congue, elit sed consequat auctor, nunc nulla vulputate dui, nec tempus mauris erat eget ipsum. Suspendisse sagittis. Nullam vitae diam. Proin dolor. Nulla semper tellus id nunc interdum feugiat. Sed nec metus facilisis lorem tristique aliquet. Phasellus fermentum convallis ligula. Donec luctus aliquet odio. Etiam ligula tortor, dictum eu, placerat eget, venenatis a, magna. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Etiam laoreet, libero et tristique pellentesque, tellus sem mollis dui, in sodales elit erat vitae risus. Duis a mi fringilla mi lacinia mattis. Integer eu lacus. Quisque imperdiet, erat nonummy ultricies ornare, elit elit fermentum risus, at fringilla purus mauris a nunc. In at pede. Cras vulputate velit eu sem. Pellentesque ut ipsum ac mi',
							'commentcontent' => 'ac metus vitae velit egestas lacinia. Sed congue, elit sed consequat auctor, nunc nulla vulputate dui, nec tempus mauris erat eget ipsum. Suspendisse sagittis. Nullam vitae diam. Proin dolor. Nulla semper tellus id nunc interdum feugiat. Sed nec metus facilisis lorem tristique aliquet. Phasellus fermentum convallis ligula. Donec luctus aliquet odio. Etiam ligula tortor, dictum eu, placerat eget, venenatis a, magna. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Etiam laoreet, libero et tristique pellentesque, tellus sem mollis dui, in sodales elit erat vitae risus. Duis a mi fringilla mi lacinia mattis. Integer eu lacus. Quisque imperdiet, erat nonummy ultricies ornare, elit elit fermentum risus, at fringilla purus mauris a nunc. In at pede. Cras vulputate velit eu sem. Pellentesque ut ipsum ac mi',
							7 => '17x2636',
							'related_to' => '17x2636',
							8 => '',
							'parent_comments' => '',
							9 => 'user',
							'ownertype' => 'user',
							10 => 'nocreate',
							'owner_name' => 'nocreate',
							11 => 'nocreate',
							'owner_firstname' => 'nocreate',
							12 => 'cbTest',
							'owner_lastname' => 'cbTest',
							13 => 'nocreate',
							'creator_name' => 'nocreate',
							14 => 'nocreate',
							'creator_firstname' => 'nocreate',
							15 => 'cbTest',
							'creator_lastname' => 'cbTest',
						),
						array(
							0 => '19x6',
							'creator' => '19x6',
							1 => '19x6',
							'assigned_user_id' => '19x6',
							2 => 'TicketComments',
							'setype' => 'TicketComments',
							3 => '2015-07-22 01:36:20',
							'createdtime' => '2015-07-22 01:36:20',
							4 => '2015-07-22 01:36:20',
							'modifiedtime' => '2015-07-22 01:36:20',
							5 => '0',
							'id' => '0',
							6 => 'lorem fringilla ornare placerat, orci lacus vestibulum lorem, sit amet ultricies sem magna nec quam. Curabitur vel lectus. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec dignissim magna a tortor. Nunc commodo auctor velit. Aliquam nisl. Nulla eu neque pellentesque massa lobortis',
							'commentcontent' => 'lorem fringilla ornare placerat, orci lacus vestibulum lorem, sit amet ultricies sem magna nec quam. Curabitur vel lectus. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec dignissim magna a tortor. Nunc commodo auctor velit. Aliquam nisl. Nulla eu neque pellentesque massa lobortis',
							7 => '17x2636',
							'related_to' => '17x2636',
							8 => '',
							'parent_comments' => '',
							9 => 'user',
							'ownertype' => 'user',
							10 => 'testmdy',
							'owner_name' => 'testmdy',
							11 => 'cbTest',
							'owner_firstname' => 'cbTest',
							12 => 'testmdy',
							'owner_lastname' => 'testmdy',
							13 => 'testmdy',
							'creator_name' => 'testmdy',
							14 => 'cbTest',
							'creator_firstname' => 'cbTest',
							15 => 'testmdy',
							'creator_lastname' => 'testmdy',
						),
					),
				),
				'HelpDesk Modcomments limit'
			),
			array(
				'17x2636', 'HelpDesk', 'ModComments', array(
					'productDiscriminator'=>'',
					//'columns'=>'productname,product_no,id',
					'limit'=>'3',
					'offset'=>'0',
					'orderby'=>'commentcontent'
				),
				1, array(
					'records' => array(
						array(
							0 => '19x11',
							'creator' => '19x11',
							1 => '19x11',
							'assigned_user_id' => '19x11',
							2 => 'TicketComments',
							'setype' => 'TicketComments',
							3 => '2015-06-20 07:43:22',
							'createdtime' => '2015-06-20 07:43:22',
							4 => '2015-06-20 07:43:22',
							'modifiedtime' => '2015-06-20 07:43:22',
							5 => '0',
							'id' => '0',
							6 => 'ac metus vitae velit egestas lacinia. Sed congue, elit sed consequat auctor, nunc nulla vulputate dui, nec tempus mauris erat eget ipsum. Suspendisse sagittis. Nullam vitae diam. Proin dolor. Nulla semper tellus id nunc interdum feugiat. Sed nec metus facilisis lorem tristique aliquet. Phasellus fermentum convallis ligula. Donec luctus aliquet odio. Etiam ligula tortor, dictum eu, placerat eget, venenatis a, magna. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Etiam laoreet, libero et tristique pellentesque, tellus sem mollis dui, in sodales elit erat vitae risus. Duis a mi fringilla mi lacinia mattis. Integer eu lacus. Quisque imperdiet, erat nonummy ultricies ornare, elit elit fermentum risus, at fringilla purus mauris a nunc. In at pede. Cras vulputate velit eu sem. Pellentesque ut ipsum ac mi',
							'commentcontent' => 'ac metus vitae velit egestas lacinia. Sed congue, elit sed consequat auctor, nunc nulla vulputate dui, nec tempus mauris erat eget ipsum. Suspendisse sagittis. Nullam vitae diam. Proin dolor. Nulla semper tellus id nunc interdum feugiat. Sed nec metus facilisis lorem tristique aliquet. Phasellus fermentum convallis ligula. Donec luctus aliquet odio. Etiam ligula tortor, dictum eu, placerat eget, venenatis a, magna. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Etiam laoreet, libero et tristique pellentesque, tellus sem mollis dui, in sodales elit erat vitae risus. Duis a mi fringilla mi lacinia mattis. Integer eu lacus. Quisque imperdiet, erat nonummy ultricies ornare, elit elit fermentum risus, at fringilla purus mauris a nunc. In at pede. Cras vulputate velit eu sem. Pellentesque ut ipsum ac mi',
							7 => '17x2636',
							'related_to' => '17x2636',
							8 => '',
							'parent_comments' => '',
							9 => 'user',
							'ownertype' => 'user',
							10 => 'nocreate',
							'owner_name' => 'nocreate',
							11 => 'nocreate',
							'owner_firstname' => 'nocreate',
							12 => 'cbTest',
							'owner_lastname' => 'cbTest',
							13 => 'nocreate',
							'creator_name' => 'nocreate',
							14 => 'nocreate',
							'creator_firstname' => 'nocreate',
							15 => 'cbTest',
							'creator_lastname' => 'cbTest',
						),
						array(
							0 => '19x6',
							'creator' => '19x6',
							1 => '19x6',
							'assigned_user_id' => '19x6',
							2 => 'TicketComments',
							'setype' => 'TicketComments',
							3 => '2016-06-03 05:11:22',
							'createdtime' => '2016-06-03 05:11:22',
							4 => '2016-06-03 05:11:22',
							'modifiedtime' => '2016-06-03 05:11:22',
							5 => '0',
							'id' => '0',
							6 => 'convallis convallis dolor. Quisque tincidunt pede ac urna. Ut tincidunt vehicula risus. Nulla eget metus eu erat semper rutrum. Fusce dolor quam, elementum at, egestas a, scelerisque sed, sapien. Nunc pulvinar arcu et pede. Nunc sed orci lobortis augue scelerisque mollis. Phasellus libero mauris, aliquam eu, accumsan sed, facilisis vitae, orci. Phasellus dapibus quam quis diam. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Fusce aliquet magna a neque. Nullam ut nisi a odio semper cursus. Integer mollis. Integer tincidunt aliquam arcu. Aliquam ultrices iaculis odio. Nam interdum enim non nisi. Aenean eget metus. In nec orci. Donec nibh. Quisque nonummy ipsum non arcu. Vivamus sit amet risus. Donec egestas. Aliquam nec enim. Nunc ut erat. Sed nunc est, mollis non, cursus non, egestas a, dui. Cras pellentesque. Sed dictum. Proin eget odio.',
							'commentcontent' => 'convallis convallis dolor. Quisque tincidunt pede ac urna. Ut tincidunt vehicula risus. Nulla eget metus eu erat semper rutrum. Fusce dolor quam, elementum at, egestas a, scelerisque sed, sapien. Nunc pulvinar arcu et pede. Nunc sed orci lobortis augue scelerisque mollis. Phasellus libero mauris, aliquam eu, accumsan sed, facilisis vitae, orci. Phasellus dapibus quam quis diam. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Fusce aliquet magna a neque. Nullam ut nisi a odio semper cursus. Integer mollis. Integer tincidunt aliquam arcu. Aliquam ultrices iaculis odio. Nam interdum enim non nisi. Aenean eget metus. In nec orci. Donec nibh. Quisque nonummy ipsum non arcu. Vivamus sit amet risus. Donec egestas. Aliquam nec enim. Nunc ut erat. Sed nunc est, mollis non, cursus non, egestas a, dui. Cras pellentesque. Sed dictum. Proin eget odio.',
							7 => '17x2636',
							'related_to' => '17x2636',
							8 => '',
							'parent_comments' => '',
							9 => 'user',
							'ownertype' => 'user',
							10 => 'testmdy',
							'owner_name' => 'testmdy',
							11 => 'cbTest',
							'owner_firstname' => 'cbTest',
							12 => 'testmdy',
							'owner_lastname' => 'testmdy',
							13 => 'testmdy',
							'creator_name' => 'testmdy',
							14 => 'cbTest',
							'creator_firstname' => 'cbTest',
							15 => 'testmdy',
							'creator_lastname' => 'testmdy',
						),
						array(
							0 => '19x11',
							'creator' => '19x11',
							1 => '19x11',
							'assigned_user_id' => '19x11',
							2 => 'TicketComments',
							'setype' => 'TicketComments',
							3 => '2016-01-04 00:55:52',
							'createdtime' => '2016-01-04 00:55:52',
							4 => '2016-01-04 00:55:52',
							'modifiedtime' => '2016-01-04 00:55:52',
							5 => '0',
							'id' => '0',
							6 => 'dui. Suspendisse ac metus vitae velit egestas lacinia. Sed congue, elit sed consequat auctor, nunc nulla vulputate dui, nec tempus mauris erat eget ipsum. Suspendisse sagittis. Nullam vitae diam. Proin dolor. Nulla semper tellus id nunc interdum feugiat. Sed nec metus facilisis lorem tristique aliquet. Phasellus fermentum convallis ligula. Donec luctus aliquet odio. Etiam ligula tortor, dictum eu, placerat eget, venenatis a, magna. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Etiam laoreet, libero et tristique pellentesque, tellus sem mollis dui, in sodales elit erat vitae risus. Duis a mi fringilla mi lacinia mattis. Integer eu lacus. Quisque imperdiet, erat nonummy ultricies ornare, elit elit fermentum risus, at fringilla purus mauris',
							'commentcontent' => 'dui. Suspendisse ac metus vitae velit egestas lacinia. Sed congue, elit sed consequat auctor, nunc nulla vulputate dui, nec tempus mauris erat eget ipsum. Suspendisse sagittis. Nullam vitae diam. Proin dolor. Nulla semper tellus id nunc interdum feugiat. Sed nec metus facilisis lorem tristique aliquet. Phasellus fermentum convallis ligula. Donec luctus aliquet odio. Etiam ligula tortor, dictum eu, placerat eget, venenatis a, magna. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Etiam laoreet, libero et tristique pellentesque, tellus sem mollis dui, in sodales elit erat vitae risus. Duis a mi fringilla mi lacinia mattis. Integer eu lacus. Quisque imperdiet, erat nonummy ultricies ornare, elit elit fermentum risus, at fringilla purus mauris',
							7 => '17x2636',
							'related_to' => '17x2636',
							8 => '',
							'parent_comments' => '',
							9 => 'user',
							'ownertype' => 'user',
							10 => 'nocreate',
							'owner_name' => 'nocreate',
							11 => 'nocreate',
							'owner_firstname' => 'nocreate',
							12 => 'cbTest',
							'owner_lastname' => 'cbTest',
							13 => 'nocreate',
							'creator_name' => 'nocreate',
							14 => 'nocreate',
							'creator_firstname' => 'nocreate',
							15 => 'cbTest',
							'creator_lastname' => 'cbTest',
						),
					),
				),
				'HelpDesk Modcomments orderby and limit'
			),
			array(
				'17x2636', 'HelpDesk', 'ModComments', array(
					'productDiscriminator'=>'',
					//'columns'=>'productname,product_no,id',
					'limit'=>'2',
					'offset'=>'1',
					'orderby'=>'commentcontent'
				),
				1, array(
					'records' => array(
						array(
							0 => '19x6',
							'creator' => '19x6',
							1 => '19x6',
							'assigned_user_id' => '19x6',
							2 => 'TicketComments',
							'setype' => 'TicketComments',
							3 => '2016-06-03 05:11:22',
							'createdtime' => '2016-06-03 05:11:22',
							4 => '2016-06-03 05:11:22',
							'modifiedtime' => '2016-06-03 05:11:22',
							5 => '0',
							'id' => '0',
							6 => 'convallis convallis dolor. Quisque tincidunt pede ac urna. Ut tincidunt vehicula risus. Nulla eget metus eu erat semper rutrum. Fusce dolor quam, elementum at, egestas a, scelerisque sed, sapien. Nunc pulvinar arcu et pede. Nunc sed orci lobortis augue scelerisque mollis. Phasellus libero mauris, aliquam eu, accumsan sed, facilisis vitae, orci. Phasellus dapibus quam quis diam. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Fusce aliquet magna a neque. Nullam ut nisi a odio semper cursus. Integer mollis. Integer tincidunt aliquam arcu. Aliquam ultrices iaculis odio. Nam interdum enim non nisi. Aenean eget metus. In nec orci. Donec nibh. Quisque nonummy ipsum non arcu. Vivamus sit amet risus. Donec egestas. Aliquam nec enim. Nunc ut erat. Sed nunc est, mollis non, cursus non, egestas a, dui. Cras pellentesque. Sed dictum. Proin eget odio.',
							'commentcontent' => 'convallis convallis dolor. Quisque tincidunt pede ac urna. Ut tincidunt vehicula risus. Nulla eget metus eu erat semper rutrum. Fusce dolor quam, elementum at, egestas a, scelerisque sed, sapien. Nunc pulvinar arcu et pede. Nunc sed orci lobortis augue scelerisque mollis. Phasellus libero mauris, aliquam eu, accumsan sed, facilisis vitae, orci. Phasellus dapibus quam quis diam. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Fusce aliquet magna a neque. Nullam ut nisi a odio semper cursus. Integer mollis. Integer tincidunt aliquam arcu. Aliquam ultrices iaculis odio. Nam interdum enim non nisi. Aenean eget metus. In nec orci. Donec nibh. Quisque nonummy ipsum non arcu. Vivamus sit amet risus. Donec egestas. Aliquam nec enim. Nunc ut erat. Sed nunc est, mollis non, cursus non, egestas a, dui. Cras pellentesque. Sed dictum. Proin eget odio.',
							7 => '17x2636',
							'related_to' => '17x2636',
							8 => '',
							'parent_comments' => '',
							9 => 'user',
							'ownertype' => 'user',
							10 => 'testmdy',
							'owner_name' => 'testmdy',
							11 => 'cbTest',
							'owner_firstname' => 'cbTest',
							12 => 'testmdy',
							'owner_lastname' => 'testmdy',
							13 => 'testmdy',
							'creator_name' => 'testmdy',
							14 => 'cbTest',
							'creator_firstname' => 'cbTest',
							15 => 'testmdy',
							'creator_lastname' => 'testmdy',
						),
						array(
							0 => '19x11',
							'creator' => '19x11',
							1 => '19x11',
							'assigned_user_id' => '19x11',
							2 => 'TicketComments',
							'setype' => 'TicketComments',
							3 => '2016-01-04 00:55:52',
							'createdtime' => '2016-01-04 00:55:52',
							4 => '2016-01-04 00:55:52',
							'modifiedtime' => '2016-01-04 00:55:52',
							5 => '0',
							'id' => '0',
							6 => 'dui. Suspendisse ac metus vitae velit egestas lacinia. Sed congue, elit sed consequat auctor, nunc nulla vulputate dui, nec tempus mauris erat eget ipsum. Suspendisse sagittis. Nullam vitae diam. Proin dolor. Nulla semper tellus id nunc interdum feugiat. Sed nec metus facilisis lorem tristique aliquet. Phasellus fermentum convallis ligula. Donec luctus aliquet odio. Etiam ligula tortor, dictum eu, placerat eget, venenatis a, magna. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Etiam laoreet, libero et tristique pellentesque, tellus sem mollis dui, in sodales elit erat vitae risus. Duis a mi fringilla mi lacinia mattis. Integer eu lacus. Quisque imperdiet, erat nonummy ultricies ornare, elit elit fermentum risus, at fringilla purus mauris',
							'commentcontent' => 'dui. Suspendisse ac metus vitae velit egestas lacinia. Sed congue, elit sed consequat auctor, nunc nulla vulputate dui, nec tempus mauris erat eget ipsum. Suspendisse sagittis. Nullam vitae diam. Proin dolor. Nulla semper tellus id nunc interdum feugiat. Sed nec metus facilisis lorem tristique aliquet. Phasellus fermentum convallis ligula. Donec luctus aliquet odio. Etiam ligula tortor, dictum eu, placerat eget, venenatis a, magna. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Etiam laoreet, libero et tristique pellentesque, tellus sem mollis dui, in sodales elit erat vitae risus. Duis a mi fringilla mi lacinia mattis. Integer eu lacus. Quisque imperdiet, erat nonummy ultricies ornare, elit elit fermentum risus, at fringilla purus mauris',
							7 => '17x2636',
							'related_to' => '17x2636',
							8 => '',
							'parent_comments' => '',
							9 => 'user',
							'ownertype' => 'user',
							10 => 'nocreate',
							'owner_name' => 'nocreate',
							11 => 'nocreate',
							'owner_firstname' => 'nocreate',
							12 => 'cbTest',
							'owner_lastname' => 'cbTest',
							13 => 'nocreate',
							'creator_name' => 'nocreate',
							14 => 'nocreate',
							'creator_firstname' => 'nocreate',
							15 => 'cbTest',
							'creator_lastname' => 'cbTest',
						),
					),
				),
				'HelpDesk Modcomments orderby and limit'
			),
			array(
				'11x415', 'Accounts', 'ModComments', array('productDiscriminator'=>''),
				1, array(
					'records' => array(
						array(
							0 => 'cursus a, enim. Suspendisse aliquet, sem ut cursus luctus, ipsum leo elementum sem, vitae aliquam eros turpis non enim. Mauris quis turpis vitae purus gravida sagittis. Duis gravida. Praesent eu nulla at sem molestie sodales. Mauris blandit enim consequat purus. Maecenas libero est, congue a, aliquet vel, vulputate eu, odio. Phasellus at augue id ante dictum cursus. Nunc mauris elit, dictum eu, eleifend nec, malesuada ut, sem. Nulla interdum. Curabitur dictum. Phasellus in felis. Nulla tempor augue ac ipsum. Phasellus vitae mauris sit amet lorem semper auctor. Mauris vel turpis. Aliquam adipiscing lobortis risus. In mi pede, nonummy ut, molestie in, tempus eu, ligula. Aenean euismod mauris eu elit. Nulla facilisi. Sed neque. Sed eget lacus. Mauris non dui nec urna suscipit nonummy. Fusce fermentum fermentum arcu. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia',
							'commentcontent' => 'cursus a, enim. Suspendisse aliquet, sem ut cursus luctus, ipsum leo elementum sem, vitae aliquam eros turpis non enim. Mauris quis turpis vitae purus gravida sagittis. Duis gravida. Praesent eu nulla at sem molestie sodales. Mauris blandit enim consequat purus. Maecenas libero est, congue a, aliquet vel, vulputate eu, odio. Phasellus at augue id ante dictum cursus. Nunc mauris elit, dictum eu, eleifend nec, malesuada ut, sem. Nulla interdum. Curabitur dictum. Phasellus in felis. Nulla tempor augue ac ipsum. Phasellus vitae mauris sit amet lorem semper auctor. Mauris vel turpis. Aliquam adipiscing lobortis risus. In mi pede, nonummy ut, molestie in, tempus eu, ligula. Aenean euismod mauris eu elit. Nulla facilisi. Sed neque. Sed eget lacus. Mauris non dui nec urna suscipit nonummy. Fusce fermentum fermentum arcu. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia',
							1 => '9',
							'assigned_user_id' => '19x9',
							2 => '9',
							'smownerid' => '9',
							3 => 'cbTest',
							'owner_firstname' => 'cbTest',
							4 => 'testinactive',
							'owner_lastname' => 'testinactive',
							5 => '415',
							'related_to' => '11x415',
							6 => '1',
							'creator' => '19x1',
							7 => '1',
							'smcreatorid' => '1',
							8 => 'cbTest',
							'creator_firstname' => 'cbTest',
							9 => 'testinactive',
							'creator_lastname' => 'testinactive',
							10 => '2015-10-16 01:45:44',
							'createdtime' => '2015-10-16 01:45:44',
							11 => '2016-03-20 09:23:14',
							'modifiedtime' => '2016-03-20 09:23:14',
							12 => '0',
							'parent_comments' => '',
							13 => 'gcarris@hotmail.com',
							'relatedassignedemail' => 'gcarris@hotmail.com',
							14 => '18428',
							'modcommentsid' => '18428',
							15 => 'f083fcf0e8e8ae41c35366fe0f04801a9eaff189',
							'cbuuid' => 'f083fcf0e8e8ae41c35366fe0f04801a9eaff189',
							'id' => '30x18428',
						),
						array(
							0 => 'orci sem eget massa. Suspendisse eleifend. Cras sed leo. Cras vehicula aliquet libero. Integer in magna. Phasellus dolor elit, pellentesque a, facilisis non, bibendum sed, est. Nunc laoreet lectus quis massa. Mauris vestibulum, neque sed dictum eleifend, nunc risus varius orci, in consequat enim diam vel arcu. Curabitur ut odio vel est tempor bibendum. Donec felis orci, adipiscing non, luctus sit amet, faucibus ut, nulla. Cras eu tellus eu augue porttitor interdum. Sed auctor odio a purus. Duis elementum, dui quis accumsan convallis, ante',
							'creator' => '19x1',
							1 => '10',
							'assigned_user_id' => '19x10',
							2 => '10',
							3 => 'cbTest',
							'createdtime' => '2015-10-24 05:51:37',
							4 => 'testtz',
							'modifiedtime' => '2016-04-18 08:33:45',
							5 => '415',
							'id' => '30x18912',
							6 => '1',
							'commentcontent' => 'orci sem eget massa. Suspendisse eleifend. Cras sed leo. Cras vehicula aliquet libero. Integer in magna. Phasellus dolor elit, pellentesque a, facilisis non, bibendum sed, est. Nunc laoreet lectus quis massa. Mauris vestibulum, neque sed dictum eleifend, nunc risus varius orci, in consequat enim diam vel arcu. Curabitur ut odio vel est tempor bibendum. Donec felis orci, adipiscing non, luctus sit amet, faucibus ut, nulla. Cras eu tellus eu augue porttitor interdum. Sed auctor odio a purus. Duis elementum, dui quis accumsan convallis, ante',
							7 => '1',
							'related_to' => '11x415',
							8 => 'cbTest',
							'parent_comments' => '',
							9 => 'user',
							10 => 'testmdy',
							9 => 'testtz',
							10 => '2015-10-24 05:51:37',
							'smownerid' => '10',
							'owner_firstname' => 'cbTest',
							'owner_lastname' => 'testtz',
							'smcreatorid' => '1',
							'creator_firstname' => 'cbTest',
							'creator_lastname' => 'testtz',
							11 => '2016-04-18 08:33:45',
							12 => '0',
							13 => 'gcarris@hotmail.com',
							'relatedassignedemail' => 'gcarris@hotmail.com',
							14 => '18912',
							'modcommentsid' => '18912',
							15 => 'bb98a9282d4ab7f01d09e8c546e9bbc358409d3a',
							'cbuuid' => 'bb98a9282d4ab7f01d09e8c546e9bbc358409d3a',
						),
					),
				),
				'Accounts Modcomments'
			),
			array(
				'11x415', 'Accounts', 'ModComments', array('productDiscriminator'=>'', 'offset' => 1),
				1, array(
					'records' => array(
						array(
							0 => 'orci sem eget massa. Suspendisse eleifend. Cras sed leo. Cras vehicula aliquet libero. Integer in magna. Phasellus dolor elit, pellentesque a, facilisis non, bibendum sed, est. Nunc laoreet lectus quis massa. Mauris vestibulum, neque sed dictum eleifend, nunc risus varius orci, in consequat enim diam vel arcu. Curabitur ut odio vel est tempor bibendum. Donec felis orci, adipiscing non, luctus sit amet, faucibus ut, nulla. Cras eu tellus eu augue porttitor interdum. Sed auctor odio a purus. Duis elementum, dui quis accumsan convallis, ante',
							'creator' => '19x1',
							1 => '10',
							'assigned_user_id' => '19x10',
							2 => '10',
							3 => 'cbTest',
							'createdtime' => '2015-10-24 05:51:37',
							4 => 'testtz',
							'modifiedtime' => '2016-04-18 08:33:45',
							5 => '415',
							'id' => '30x18912',
							6 => '1',
							'commentcontent' => 'orci sem eget massa. Suspendisse eleifend. Cras sed leo. Cras vehicula aliquet libero. Integer in magna. Phasellus dolor elit, pellentesque a, facilisis non, bibendum sed, est. Nunc laoreet lectus quis massa. Mauris vestibulum, neque sed dictum eleifend, nunc risus varius orci, in consequat enim diam vel arcu. Curabitur ut odio vel est tempor bibendum. Donec felis orci, adipiscing non, luctus sit amet, faucibus ut, nulla. Cras eu tellus eu augue porttitor interdum. Sed auctor odio a purus. Duis elementum, dui quis accumsan convallis, ante',
							7 => '1',
							'related_to' => '11x415',
							8 => 'cbTest',
							'parent_comments' => '',
							9 => 'user',
							10 => 'testmdy',
							9 => 'testtz',
							10 => '2015-10-24 05:51:37',
							'smownerid' => '10',
							'owner_firstname' => 'cbTest',
							'owner_lastname' => 'testtz',
							'smcreatorid' => '1',
							'creator_firstname' => 'cbTest',
							'creator_lastname' => 'testtz',
							11 => '2016-04-18 08:33:45',
							12 => '0',
							13 => 'gcarris@hotmail.com',
							'relatedassignedemail' => 'gcarris@hotmail.com',
							14 => '18912',
							'modcommentsid' => '18912',
							15 => 'bb98a9282d4ab7f01d09e8c546e9bbc358409d3a',
							'cbuuid' => 'bb98a9282d4ab7f01d09e8c546e9bbc358409d3a',
						),
					),
				),
				'Accounts Modcomments offset 1'
			),
			array(
				'11x421', 'Accounts', 'ModComments', array('productDiscriminator'=>''), 1, array('records' => array()),'Accounts Modcomments No Comments'
			),
			array(
				'11x74', 'Accounts', 'Emails', array('productDiscriminator'=>'', 'limit' => 2),
				1, array(
					'records' => array(
						array(
							0 => '2017-01-19',
							1 => 'noreply@tsolucio.com',
							'assigned_user_id' => '19x11',
							2 => '',
							3 => '["lina@yahoo.com"]',
							'createdtime' => '2016-05-30 16:40:10',
							4 => 'Emails',
							'modifiedtime' => '2016-06-07 11:20:15',
							5 => '["eu@etnuncQuisque.net"]',
							'id' => '16x26736',
							6 => '[""]',
							7 => '11',
							8 => '11',
							9 => 'nocreate',
							10 => 'cbTest',
							'smownerid' => '11',
							'owner_firstname' => 'nocreate',
							'owner_lastname' => 'cbTest',
							11 => '74@9|',
							12 => '10',
							13 => 'SENT',
							14 => '2016-06-07 11:20:15',
							15 => '1',
							'cbuuid' => 'd3f2b69e0ba108184c8a9fd84ae92dfdf8f0a217',
							'date_start' => '2017-01-19',
							'from_email' => 'noreply@tsolucio.com',
							'semodule' => '',
							'to_email' => '["lina@yahoo.com"]',
							'activitytype' => 'Emails',
							'cc_email' => '["eu@etnuncQuisque.net"]',
							'bcc_email' => '[""]',
							'idlists' => '74@9|',
							'access_count' => '10',
							'email_flag' => 'SENT',
							'modifiedby' => '19x1',
							16 => '',
							'bounce' => '',
							17 => '',
							'clicked' => '',
							18 => '',
							'spamreport' => '',
							19 => '',
							'delivered' => '',
							20 => '',
							'dropped' => '',
							21 => '',
							'open' => '',
							22 => '',
							'unsubscribe' => '',
							23 => '',
							'replyto' => '',
							24 => '2016-05-30 16:40:10',
							25 => 'magna. Ut tincidunt orci quis lectus. Nullam suscipit, est',
							'subject' => 'magna. Ut tincidunt orci quis lectus. Nullam suscipit, est',
							26 => '11:23:32',
							'time_start' => '11:23:32',
							27 => 'ac mattis semper, dui lectus rutrum urna, nec luctus felis purus ac tellus. Suspendisse sed dolor. Fusce mi lorem, vehicula et, rutrum eu, ultrices sit amet, risus. Donec nibh enim, gravida sit amet, dapibus id, blandit at, nisi. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Proin vel nisl. Quisque fringilla euismod enim. Etiam gravida molestie arcu. Sed eu nibh vulputate mauris sagittis placerat. Cras dictum ultricies ligula. Nullam enim. Sed nulla ante, iaculis nec, eleifend non, dapibus rutrum, justo. Praesent luctus. Curabitur egestas nunc sed libero. Proin sed turpis nec mauris blandit mattis. Cras eget nisi dictum augue malesuada malesuada. Integer id magna et ipsum cursus vestibulum. Mauris magna. Duis dignissim tempor arcu. Vestibulum ut eros non enim commodo hendrerit. Donec porttitor tellus non magna. Nam ligula elit, pretium et, rutrum non, hendrerit id, ante. Nunc mauris sapien, cursus in, hendrerit consectetuer, cursus et, magna. Praesent interdum ligula eu enim. Etiam imperdiet dictum magna. Ut tincidunt orci quis lectus. Nullam suscipit, est ac facilisis facilisis, magna tellus faucibus leo, in lobortis tellus justo sit amet nulla. Donec non justo. Proin non massa non ante bibendum ullamcorper. Duis cursus, diam at pretium aliquet, metus urna convallis erat, eget tincidunt dui augue eu tellus. Phasellus elit pede, malesuada vel, venenatis vel, faucibus id, libero. Donec consectetuer mauris id',
							'description' => 'ac mattis semper, dui lectus rutrum urna, nec luctus felis purus ac tellus. Suspendisse sed dolor. Fusce mi lorem, vehicula et, rutrum eu, ultrices sit amet, risus. Donec nibh enim, gravida sit amet, dapibus id, blandit at, nisi. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Proin vel nisl. Quisque fringilla euismod enim. Etiam gravida molestie arcu. Sed eu nibh vulputate mauris sagittis placerat. Cras dictum ultricies ligula. Nullam enim. Sed nulla ante, iaculis nec, eleifend non, dapibus rutrum, justo. Praesent luctus. Curabitur egestas nunc sed libero. Proin sed turpis nec mauris blandit mattis. Cras eget nisi dictum augue malesuada malesuada. Integer id magna et ipsum cursus vestibulum. Mauris magna. Duis dignissim tempor arcu. Vestibulum ut eros non enim commodo hendrerit. Donec porttitor tellus non magna. Nam ligula elit, pretium et, rutrum non, hendrerit id, ante. Nunc mauris sapien, cursus in, hendrerit consectetuer, cursus et, magna. Praesent interdum ligula eu enim. Etiam imperdiet dictum magna. Ut tincidunt orci quis lectus. Nullam suscipit, est ac facilisis facilisis, magna tellus faucibus leo, in lobortis tellus justo sit amet nulla. Donec non justo. Proin non massa non ante bibendum ullamcorper. Duis cursus, diam at pretium aliquet, metus urna convallis erat, eget tincidunt dui augue eu tellus. Phasellus elit pede, malesuada vel, venenatis vel, faucibus id, libero. Donec consectetuer mauris id',
							28 => '26736',
							'activityid' => '26736',
							29 => 'd3f2b69e0ba108184c8a9fd84ae92dfdf8f0a217',
						),
						array(
							0 => '2015-06-23',
							1 => 'noreply@tsolucio.com',
							'assigned_user_id' => '19x10',
							2 => '',
							3 => '["lina@yahoo.com","lina@yahoo.com"]',
							'createdtime' => '2016-06-04 09:15:41',
							4 => 'Emails',
							'modifiedtime' => '2016-06-15 10:05:33',
							5 => '[""]',
							'id' => '16x26784',
							6 => '["Maecenas.mi.felis@arcuNuncmauris.net"]',
							7 => '10',
							8 => '10',
							9 => 'cbTest',
							10 => 'testtz',
							'smownerid' => '10',
							'owner_firstname' => 'cbTest',
							'owner_lastname' => 'testtz',
							11 => '1084@80|74@9|',
							12 => '4',
							13 => 'SENT',
							14 => '2016-06-15 10:05:33',
							15 => '1',
							'cbuuid' => '83e4c79191fc03b99d27c7e0fb1da96e43ed4fda',
							'date_start' => '2015-06-23',
							'from_email' => 'noreply@tsolucio.com',
							'semodule' => '',
							'to_email' => '["lina@yahoo.com","lina@yahoo.com"]',
							'activitytype' => 'Emails',
							'cc_email' => '[""]',
							'bcc_email' => '["Maecenas.mi.felis@arcuNuncmauris.net"]',
							'idlists' => '1084@80|74@9|',
							'access_count' => '4',
							'email_flag' => 'SENT',
							'modifiedby' => '19x1',
							16 => '',
							'bounce' => '',
							17 => '',
							'clicked' => '',
							18 => '',
							'spamreport' => '',
							19 => '',
							'delivered' => '',
							20 => '',
							'dropped' => '',
							21 => '',
							'open' => '',
							22 => '',
							'unsubscribe' => '',
							23 => '',
							'replyto' => '',
							24 => '2016-06-04 09:15:41',
							25 => 'vestibulum, neque',
							'subject' => 'vestibulum, neque',
							26 => '16:29:10',
							'time_start' => '16:29:10',
							27 => 'Cras dictum ultricies ligula. Nullam enim. Sed nulla ante, iaculis nec, eleifend non, dapibus rutrum, justo. Praesent luctus. Curabitur egestas nunc sed libero. Proin sed turpis nec mauris blandit mattis. Cras eget nisi dictum augue malesuada malesuada. Integer id magna et ipsum cursus vestibulum. Mauris magna. Duis dignissim tempor arcu. Vestibulum ut eros non enim commodo hendrerit. Donec porttitor tellus non magna. Nam ligula elit, pretium et, rutrum non, hendrerit id, ante. Nunc mauris sapien, cursus in, hendrerit consectetuer, cursus et, magna. Praesent interdum ligula eu enim. Etiam imperdiet dictum magna. Ut tincidunt orci quis lectus. Nullam suscipit, est ac facilisis facilisis, magna tellus faucibus leo, in lobortis tellus justo sit amet nulla. Donec non justo. Proin non massa non ante bibendum ullamcorper. Duis cursus, diam at pretium aliquet, metus urna convallis erat, eget tincidunt dui augue eu tellus. Phasellus elit pede, malesuada vel, venenatis vel, faucibus id, libero. Donec consectetuer mauris',
							'description' => 'Cras dictum ultricies ligula. Nullam enim. Sed nulla ante, iaculis nec, eleifend non, dapibus rutrum, justo. Praesent luctus. Curabitur egestas nunc sed libero. Proin sed turpis nec mauris blandit mattis. Cras eget nisi dictum augue malesuada malesuada. Integer id magna et ipsum cursus vestibulum. Mauris magna. Duis dignissim tempor arcu. Vestibulum ut eros non enim commodo hendrerit. Donec porttitor tellus non magna. Nam ligula elit, pretium et, rutrum non, hendrerit id, ante. Nunc mauris sapien, cursus in, hendrerit consectetuer, cursus et, magna. Praesent interdum ligula eu enim. Etiam imperdiet dictum magna. Ut tincidunt orci quis lectus. Nullam suscipit, est ac facilisis facilisis, magna tellus faucibus leo, in lobortis tellus justo sit amet nulla. Donec non justo. Proin non massa non ante bibendum ullamcorper. Duis cursus, diam at pretium aliquet, metus urna convallis erat, eget tincidunt dui augue eu tellus. Phasellus elit pede, malesuada vel, venenatis vel, faucibus id, libero. Donec consectetuer mauris',
							28 => '26784',
							'activityid' => '26784',
							29 => '83e4c79191fc03b99d27c7e0fb1da96e43ed4fda',
						),
					),
				),
				'Accounts Modcomments offset 1'
			),
		);
	}

	/**
	 * Method testgetRelatedRecords
	 * @test
	 * @dataProvider getRelatedRecordsProvider
	 */
	public function testgetRelatedRecords($id, $module, $relatedModule, $queryParameters, $userid, $expected, $msg) {
		global $current_user;
		$holduser = $current_user;
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($userid);
		$current_user = $user;
		$actual = getRelatedRecords($id, $module, $relatedModule, $queryParameters, $current_user);
		$this->assertEqualsCanonicalizing($expected, $actual, $msg);
		$current_user = $holduser;
	}

	/**
	 * Method testFAQComments
	 * @test
	 */
	public function testFAQComments() {
		global $adb, $current_user;
		$cnt = $adb->query('select count(*) as cnt from vtiger_faqcomments where faqid=4686');
		if ($cnt->fields['cnt']<2) {
			$adb->query('insert ignore into vtiger_faqcomments (faqid,comments,createdtime) values (4686,"just a comment 1", "2020-05-05 05:05:05")');
			$adb->query('insert ignore into vtiger_faqcomments (faqid,comments,createdtime) values (4686,"just a comment 2", "2020-05-05 05:05:05")');
		}
		$qparams = array(
			'productDiscriminator'=>'',
			//'columns' => 'productname, id',
		);
		$actual = getRelatedRecords(vtws_getEntityId('Faq').'x4686', 'Faq', 'ModComments', $qparams, $current_user);
		$expected= array(
			'records' => array(
				array(
					0 => '0',
					1 => '0',
					2 => 'FaqComments',
					'id' => '0',
					'creator' => '0',
					'assigned_user_id' => '0',
					'setype' => 'FaqComments',
					3 => '2020-05-05 05:05:05',
					'createdtime' => '2020-05-05 05:05:05',
					4 => '2020-05-05 05:05:05',
					'modifiedtime' => '2020-05-05 05:05:05',
					5 => '0',
					6 => 'just a comment 1',
					'commentcontent' => 'just a comment 1',
					7 => '3x4686',
					'related_to' => '3x4686',
					8 => '',
					'parent_comments' => '',
				),
				array(
					0 => '0',
					1 => '0',
					2 => 'FaqComments',
					'id' => '0',
					'creator' => '0',
					'assigned_user_id' => '0',
					'setype' => 'FaqComments',
					3 => '2020-05-05 05:05:05',
					'createdtime' => '2020-05-05 05:05:05',
					4 => '2020-05-05 05:05:05',
					'modifiedtime' => '2020-05-05 05:05:05',
					5 => '0',
					6 => 'just a comment 2',
					'commentcontent' => 'just a comment 2',
					7 => '3x4686',
					'related_to' => '3x4686',
					8 => '',
					'parent_comments' => '',
				),
			),
		);
		$this->assertEquals($expected, $actual, 'Contacts-Products Direct');
	}

	/**
	 * Method testProductsInventory
	 * @test
	 */
	public function testProductsInventory() {
		global $current_user;
		////////////////////////////
		$qparams = array(
			'productDiscriminator' => 'ProductLineQuotes',
			'columns' => 'productname, servicename, id',
		);
		$actual = getRelatedRecords(vtws_getEntityId('Quotes').'x12192', 'Quotes', 'Products', $qparams, $current_user);
		$expected= array(
			'records' => array(
				array(
					0 => '',
					'productname' => '',
					1 => 'Social and cultural event',
					'productid' => '26x9730',
					2 => '9730',
					'cbuuid' => 'bcb11c59a702245bf8cd6c67b58de37b111c0b1e',
					'id' => '26x9730',
					'servicename' => 'Social and cultural event',
					3 => '1',
					'sequence_no' => '1',
					'linetype' => 'Services',
				),
				array(
					0 => 'Lml-Bc288X 50 288W Curved Led Light Bar Used Cree Chips Off Road Spot Flood Beam New Arrival',
					'productname' => 'Lml-Bc288X 50 288W Curved Led Light Bar Used Cree Chips Off Road Spot Flood Beam New Arrival',
					1 => '',
					'productid' => '14x2630',
					2 => '2630',
					'cbuuid' => 'cf7e5cedb32c9811b6e6d8202982842f22c2ec49',
					'id' => '14x2630',
					'servicename' => '',
					3 => '2',
					'sequence_no' => '2',
					'linetype' => 'Products',
				),
				array(
					0 => 'Protective Case Cover for iPhone 6',
					'productname' => 'Protective Case Cover for iPhone 6',
					1 => '',
					'productid' => '14x2618',
					2 => '2618',
					'cbuuid' => '668d624d92e450119f769142036e7e235ec030c7',
					'id' => '14x2618',
					'servicename' => '',
					3 => '3',
					'sequence_no' => '3',
					'linetype' => 'Products',
				),
				array(
					0 => '',
					'productname' => '',
					1 => 'Set up computers, cell phones, and similar devices',
					'productid' => '26x9738',
					2 => '9738',
					'cbuuid' => 'ef0f50fff37934cc88767e196cc4a6b92d9d46d7',
					'id' => '26x9738',
					'servicename' => 'Set up computers, cell phones, and similar devices',
					3 => '4',
					'sequence_no' => '4',
					'linetype' => 'Services',
				),
				array(
					0 => 'New 3.3 Inch 9W Epistar LED Work Light',
					'productname' => 'New 3.3 Inch 9W Epistar LED Work Light',
					1 => '',
					'productid' => '14x2624',
					2 => '2624',
					'cbuuid' => '9b2f22ca7c009319b1e78f9778fc9f2df84a1aaf',
					'id' => '14x2624',
					'servicename' => '',
					3 => '5',
					'sequence_no' => '5',
					'linetype' => 'Products',
				),
				array(
					0 => 'cheap in stock muti-color lipstick',
					'productname' => 'cheap in stock muti-color lipstick',
					1 => '',
					'productid' => '14x2622',
					2 => '2622',
					'cbuuid' => '321dcfe3e3d45e08441ed92d4a729786d36d26bf',
					'id' => '14x2622',
					'servicename' => '',
					3 => '6',
					'sequence_no' => '6',
					'linetype' => 'Products',
				),
				array(
					0 => 'Car Sunshade Windshield Cover / Car Snow Cover',
					'productname' => 'Car Sunshade Windshield Cover / Car Snow Cover',
					1 => '',
					'productid' => '14x2620',
					2 => '2620',
					'cbuuid' => '08b6499c06f49c16689928879243b21e61928a5c',
					'id' => '14x2620',
					'servicename' => '',
					3 => '7',
					'sequence_no' => '7',
					'linetype' => 'Products',
				),
				array(
					0 => '',
					'productname' => '',
					1 => 'Set up computers, cell phones, and similar devices',
					'productid' => '26x9738',
					2 => '9738',
					'cbuuid' => 'ef0f50fff37934cc88767e196cc4a6b92d9d46d7',
					'id' => '26x9738',
					'servicename' => 'Set up computers, cell phones, and similar devices',
					3 => '8',
					'sequence_no' => '8',
					'linetype' => 'Services',
				),
				array(
					0 => '',
					'productname' => '',
					1 => 'Design',
					'productid' => '26x9752',
					2 => '9752',
					'cbuuid' => '9ad64a8f94fe7c23ee6abff1828e231ec17ae2a5',
					'id' => '26x9752',
					'servicename' => 'Design',
					3 => '9',
					'sequence_no' => '9',
					'linetype' => 'Services',
				),
			),
		);
		$this->assertEquals($expected, $actual, 'Contacts-Products SO');
	}

	/**
	 * Method testProductsProducts
	 * @test
	 */
	public function testProductsProducts() {
		global $adb, $current_user;
		$rs = $adb->query("select count(*) as cnt from vtiger_productcomponent inner join vtiger_crmentity on crmid=productcomponentid where deleted=0 and frompdo=2631 and topdo=2632");
		$this->assertTrue(($rs->fields['cnt']==0 || $rs->fields['cnt']==1));
		$rs = $adb->query("select count(*) as cnt from vtiger_productcomponent inner join vtiger_crmentity on crmid=productcomponentid where deleted=0 and frompdo=2631 and topdo=2633");
		$this->assertTrue(($rs->fields['cnt']==0 || $rs->fields['cnt']==1));
		$element = array(
			'frompdo' => '14x2631',
			'topdo' => '14x2632',
			'relmode' => 'Optional',
			'relfrom' => '2018-06-27',
			'relto' => '2022-06-27',
			'quantity' => '1',
			'description' => '',
			'instructions' => '',
			'cbuuid' => '6cebe554cba001a58c6347b80bd49be4eb700c23'
		);
		vtws_upsert('ProductComponent', $element, 'frompdo,topdo', 'frompdo,topdo,relmode,relfrom,relto,quantity,description,instructions', $current_user);
		$element = array(
			'frompdo' => '14x2631',
			'topdo' => '14x2633',
			'relmode' => 'Required',
			'relfrom' => '2018-06-27',
			'relto' => '2022-06-27',
			'quantity' => '1',
			'description' => '',
			'instructions' => '',
			'cbuuid' => '1f6f67cda5d84e91ba4bfa399d4550b4597d1f62'
		);
		vtws_upsert('ProductComponent', $element, 'frompdo,topdo', 'frompdo,topdo,relmode,relfrom,relto,quantity,description,instructions', $current_user);
		$rs = $adb->query("select count(*) as cnt from vtiger_productcomponent inner join vtiger_crmentity on crmid=productcomponentid where deleted=0 and frompdo=2631 and topdo=2632");
		$this->assertTrue(($rs->fields['cnt']==0 || $rs->fields['cnt']==1));
		$rs = $adb->query("select count(*) as cnt from vtiger_productcomponent inner join vtiger_crmentity on crmid=productcomponentid where deleted=0 and frompdo=2631 and topdo=2633");
		$this->assertTrue(($rs->fields['cnt']==0 || $rs->fields['cnt']==1));
		/////////////////////////
		$qparams = array(
			'productDiscriminator' => 'ProductBundle',
			'columns' => 'productname, id',
		);
		$actual = getRelatedRecords('14x2631', 'Products', 'Products', $qparams, $current_user);
		$expected= array(
			'records' => array(
				array(
					0 => 'U8 Smart Watch',
					'productname' => 'U8 Smart Watch',
					1 => '2632',
					'productid' => '2632',
					2 => '6cebe554cba001a58c6347b80bd49be4eb700c23',
					'cbuuid' => '6cebe554cba001a58c6347b80bd49be4eb700c23',
					'id' => '14x2632',
				),
				array(
					0 => 'Leagoo Lead 3s Mobile Phone',
					'productname' => 'Leagoo Lead 3s Mobile Phone',
					1 => '2633',
					'productid' => '2633',
					2 => '1f6f67cda5d84e91ba4bfa399d4550b4597d1f62',
					'cbuuid' => '1f6f67cda5d84e91ba4bfa399d4550b4597d1f62',
					'id' => '14x2633',
				),
			),
		);
		$this->assertEquals($expected, $actual, 'Products-Products Bundle exists');
		/////////////////////////
		$actual = getRelatedRecords('14x2633', 'Products', 'Products', $qparams, $current_user);
		$expected= array(
			'records' => array(
			),
		);
		$this->assertEquals($expected, $actual, 'Products-Products Bundle not exists');
		/////////////////////////
		$qparams = array(
			'productDiscriminator' => 'ProductParent',
			'columns' => 'productname, id',
		);
		$actual = getRelatedRecords('14x2631', 'Products', 'Products', $qparams, $current_user);
		$expected= array(
			'records' => array(
			),
		);
		$this->assertEquals($expected, $actual, 'Products-Products Parent not exists');
		/////////////////////////
		$actual = getRelatedRecords('14x2632', 'Products', 'Products', $qparams, $current_user);
		$expected= array(
			'records' => array(
				array(
					0 => '4Pcs 2.2Bar 32Psi Car Tyre Tire Pressure Valve Stem Caps Sensor 3 Color Eye Air Alert Tire Pressure ',
					'productname' => '4Pcs 2.2Bar 32Psi Car Tyre Tire Pressure Valve Stem Caps Sensor 3 Color Eye Air Alert Tire Pressure ',
					1 => '2631',
					'productid' => '2631',
					2 => '6cebe554cba001a58c6347b80bd49be4eb700c23',
					'cbuuid' => '6cebe554cba001a58c6347b80bd49be4eb700c23',
					'id' => '14x2631',
				),
			),
		);
		$this->assertEquals($expected, $actual, 'Products-Products Parent exists');
	}

	/**
	 * Method testProductsModule
	 * @test
	 */
	public function testProductsModule() {
		global $adb, $current_user;
		$adb->query('insert ignore into vtiger_seproductsrel values (1104,2626,"Contacts")');
		$adb->query('insert ignore into vtiger_seproductsrel values (1104,2627,"Contacts")');
		$qparams = array(
			'productDiscriminator' => 'ProductLineNone',
			'columns' => 'productname, id',
		);
		$actual = getRelatedRecords('12x1104', 'Contacts', 'Products', $qparams, $current_user);
		$expected= array(
			'records' => array(
				array(
					0 => 'Manufacturing Japan Movt Stainless Steel Back For Men Bracelet Brand Watch Wrist Wtach Quartz',
					'productname' => 'Manufacturing Japan Movt Stainless Steel Back For Men Bracelet Brand Watch Wrist Wtach Quartz',
					1 => '2626',
					'productid' => '2626',
					2 => '4973deb411bf466e943fc35fef5a2005c6720d3a',
					'cbuuid' => '4973deb411bf466e943fc35fef5a2005c6720d3a',
					'id' => '14x2626',
				),
				array(
					0 => 'Android TV BOX',
					'productname' => 'Android TV BOX',
					1 => '2627',
					'productid' => '2627',
					2 => 'f243a2ee70781bdee2a9cb9b05b1584de3cc6888',
					'cbuuid' => 'f243a2ee70781bdee2a9cb9b05b1584de3cc6888',
					'id' => '14x2627',
				),
			),
		);
		$this->assertEquals($expected, $actual, 'Contacts-Products Direct');
		////////////////////////////
		$qparams = array(
			'productDiscriminator' => 'ProductLineSalesOrder',
			'columns' => 'productname, id',
		);
		$actual = getRelatedRecords('12x1613', 'Contacts', 'Products', $qparams, $current_user);
		$expected= array(
			'records' => array(
				array(
					0 => 'U8 Smart Watch',
					'productname' => 'U8 Smart Watch',
					1 => '2632',
					'productid' => '2632',
					2 => '9a3e0706ebf020baefab732a42f4940462ca1696',
					'cbuuid' => '9a3e0706ebf020baefab732a42f4940462ca1696',
					'id' => '14x2632',
				),
				array(
					0 => 'Protective Case Cover for iPhone 6',
					'productname' => 'Protective Case Cover for iPhone 6',
					1 => '2618',
					'productid' => '2618',
					2 => '668d624d92e450119f769142036e7e235ec030c7',
					'cbuuid' => '668d624d92e450119f769142036e7e235ec030c7',
					'id' => '14x2618',
				),
				array(
					0 => 'New 3.3 Inch 9W Epistar LED Work Light',
					'productname' => 'New 3.3 Inch 9W Epistar LED Work Light',
					1 => '2624',
					'productid' => '2624',
					2 => '9b2f22ca7c009319b1e78f9778fc9f2df84a1aaf',
					'cbuuid' => '9b2f22ca7c009319b1e78f9778fc9f2df84a1aaf',
					'id' => '14x2624',
				),
				array(
					0 => 'cheap in stock muti-color lipstick',
					'productname' => 'cheap in stock muti-color lipstick',
					1 => '2622',
					'productid' => '2622',
					2 => '321dcfe3e3d45e08441ed92d4a729786d36d26bf',
					'cbuuid' => '321dcfe3e3d45e08441ed92d4a729786d36d26bf',
					'id' => '14x2622',
				),
				array(
					0 => 'Car Sunshade Windshield Cover / Car Snow Cover',
					'productname' => 'Car Sunshade Windshield Cover / Car Snow Cover',
					1 => '2620',
					'productid' => '2620',
					2 => '08b6499c06f49c16689928879243b21e61928a5c',
					'cbuuid' => '08b6499c06f49c16689928879243b21e61928a5c',
					'id' => '14x2620',
				),
			),
		);
		$this->assertEquals($expected, $actual, 'Contacts-Products SO');
		////////////////////////////
		$qparams = array(
			'productDiscriminator' => 'ProductLineSalesOrderOnly',
			'columns' => 'productname, id',
		);
		$actual = getRelatedRecords('12x1613', 'Contacts', 'Products', $qparams, $current_user);
		$this->assertEquals($expected, $actual, 'Contacts-Products SO (only)');
		////////////////////////////
		$qparams = array(
			'productDiscriminator' => 'ProductLineQuote',
			'columns' => 'productname, id',
		);
		$actual = getRelatedRecords('12x1613', 'Contacts', 'Products', $qparams, $current_user);
		$expected= array(
			'records' => array(
				array(
					0 => 'Lml-Bc288X 50 288W Curved Led Light Bar Used Cree Chips Off Road Spot Flood Beam New Arrival',
					'productname' => 'Lml-Bc288X 50 288W Curved Led Light Bar Used Cree Chips Off Road Spot Flood Beam New Arrival',
					1 => '2630',
					'productid' => '2630',
					2 => 'cf7e5cedb32c9811b6e6d8202982842f22c2ec49',
					'cbuuid' => 'cf7e5cedb32c9811b6e6d8202982842f22c2ec49',
					'id' => '14x2630',
				),
				array(
					0 => 'Protective Case Cover for iPhone 6',
					'productname' => 'Protective Case Cover for iPhone 6',
					1 => '2618',
					'productid' => '2618',
					2 => '668d624d92e450119f769142036e7e235ec030c7',
					'cbuuid' => '668d624d92e450119f769142036e7e235ec030c7',
					'id' => '14x2618',
				),
				array(
					0 => 'New 3.3 Inch 9W Epistar LED Work Light',
					'productname' => 'New 3.3 Inch 9W Epistar LED Work Light',
					1 => '2624',
					'productid' => '2624',
					2 => '9b2f22ca7c009319b1e78f9778fc9f2df84a1aaf',
					'cbuuid' => '9b2f22ca7c009319b1e78f9778fc9f2df84a1aaf',
					'id' => '14x2624',
				),
				array(
					0 => 'cheap in stock muti-color lipstick',
					'productname' => 'cheap in stock muti-color lipstick',
					1 => '2622',
					'productid' => '2622',
					2 => '321dcfe3e3d45e08441ed92d4a729786d36d26bf',
					'cbuuid' => '321dcfe3e3d45e08441ed92d4a729786d36d26bf',
					'id' => '14x2622',
				),
				array(
					0 => 'Car Sunshade Windshield Cover / Car Snow Cover',
					'productname' => 'Car Sunshade Windshield Cover / Car Snow Cover',
					1 => '2620',
					'productid' => '2620',
					2 => '08b6499c06f49c16689928879243b21e61928a5c',
					'cbuuid' => '08b6499c06f49c16689928879243b21e61928a5c',
					'id' => '14x2620',
				),
			),
		);
		$this->assertEquals($expected, $actual, 'Contacts-Products Quote');
		////////////////////////////
		$qparams = array(
			'productDiscriminator' => 'ProductLineInvoice',
			'columns' => 'productname, id',
		);
		$actual = getRelatedRecords('12x1613', 'Contacts', 'Products', $qparams, $current_user);
		$expected= array(
			'records' => array(
			),
		);
		$this->assertEquals($expected, $actual, 'Contacts-Products Invoice');
		////////////////////////////
		$qparams = array(
			'productDiscriminator' => 'ProductLineAll',
			'columns' => 'productname, id',
		);
		$actual = getRelatedRecords('12x1613', 'Contacts', 'Products', $qparams, $current_user);
		$expected= array(
			'records' => array(
				array(
					0 => 'Lml-Bc288X 50 288W Curved Led Light Bar Used Cree Chips Off Road Spot Flood Beam New Arrival',
					'productname' => 'Lml-Bc288X 50 288W Curved Led Light Bar Used Cree Chips Off Road Spot Flood Beam New Arrival',
					1 => '2630',
					'productid' => '2630',
					2 => 'cf7e5cedb32c9811b6e6d8202982842f22c2ec49',
					'cbuuid' => 'cf7e5cedb32c9811b6e6d8202982842f22c2ec49',
					'id' => '14x2630',
				),
				array(
					0 => 'Protective Case Cover for iPhone 6',
					'productname' => 'Protective Case Cover for iPhone 6',
					1 => '2618',
					'productid' => '2618',
					2 => '668d624d92e450119f769142036e7e235ec030c7',
					'cbuuid' => '668d624d92e450119f769142036e7e235ec030c7',
					'id' => '14x2618',
				),
				array(
					0 => 'New 3.3 Inch 9W Epistar LED Work Light',
					'productname' => 'New 3.3 Inch 9W Epistar LED Work Light',
					1 => '2624',
					'productid' => '2624',
					2 => '9b2f22ca7c009319b1e78f9778fc9f2df84a1aaf',
					'cbuuid' => '9b2f22ca7c009319b1e78f9778fc9f2df84a1aaf',
					'id' => '14x2624',
				),
				array(
					0 => 'cheap in stock muti-color lipstick',
					'productname' => 'cheap in stock muti-color lipstick',
					1 => '2622',
					'productid' => '2622',
					2 => '321dcfe3e3d45e08441ed92d4a729786d36d26bf',
					'cbuuid' => '321dcfe3e3d45e08441ed92d4a729786d36d26bf',
					'id' => '14x2622',
				),
				array(
					0 => 'Car Sunshade Windshield Cover / Car Snow Cover',
					'productname' => 'Car Sunshade Windshield Cover / Car Snow Cover',
					1 => '2620',
					'productid' => '2620',
					2 => '08b6499c06f49c16689928879243b21e61928a5c',
					'cbuuid' => '08b6499c06f49c16689928879243b21e61928a5c',
					'id' => '14x2620',
				),
				array(
					0 => 'U8 Smart Watch',
					'productname' => 'U8 Smart Watch',
					1 => '2632',
					'productid' => '2632',
					2 => '9a3e0706ebf020baefab732a42f4940462ca1696',
					'cbuuid' => '9a3e0706ebf020baefab732a42f4940462ca1696',
					'id' => '14x2632',
				),
			),
		);
		$this->assertEquals($expected, $actual, 'Contacts-Products All');
		////////////////////////////
		$qparams = array(
			'productDiscriminator' => 'ProductLineSalesOrder',
			'columns' => 'servicename, id',
		);
		$actual = getRelatedRecords('12x1613', 'Contacts', 'Services', $qparams, $current_user);
		$expected= array(
			'records' => array(
				array(
					0 => 'Investing',
					'servicename' => 'Investing',
					1 => '9713',
					'serviceid' => '9713',
					2 => 'd8827a99ae00c5ef9cda704173cdea5d042d39c3',
					'cbuuid' => 'd8827a99ae00c5ef9cda704173cdea5d042d39c3',
					'id' => '26x9713',
				),
				array(
					0 => 'Set up computers, cell phones, and similar devices',
					'servicename' => 'Set up computers, cell phones, and similar devices',
					1 => '9755',
					'serviceid' => '9755',
					2 => '60e70f186b72282a963338fbd4eab1ec9e8d04ea',
					'cbuuid' => '60e70f186b72282a963338fbd4eab1ec9e8d04ea',
					'id' => '26x9755',
				),
				array(
					0 => 'Bird-watching',
					'servicename' => 'Bird-watching',
					1 => '9722',
					'serviceid' => '9722',
					2 => 'b3fac938a788007f55ade8a65c0ebacc649012bd',
					'cbuuid' => 'b3fac938a788007f55ade8a65c0ebacc649012bd',
					'id' => '26x9722',
				),
			),
		);
		$this->assertEquals($expected, $actual, 'Contacts-Services SO');
		////////////////////////////
		$qparams = array(
			'productDiscriminator' => 'ProductLineQuote',
			'columns' => 'servicename, id',
		);
		$actual = getRelatedRecords('12x1613', 'Contacts', 'Services', $qparams, $current_user);
		$expected= array(
			'records' => array(
				array(
					0 => 'Social and cultural event',
					'servicename' => 'Social and cultural event',
					1 => '9730',
					'serviceid' => '9730',
					2 => 'bcb11c59a702245bf8cd6c67b58de37b111c0b1e',
					'cbuuid' => 'bcb11c59a702245bf8cd6c67b58de37b111c0b1e',
					'id' => '26x9730',
				),
				array(
					0 => 'Set up computers, cell phones, and similar devices',
					'servicename' => 'Set up computers, cell phones, and similar devices',
					1 => '9738',
					'serviceid' => '9738',
					2 => 'ef0f50fff37934cc88767e196cc4a6b92d9d46d7',
					'cbuuid' => 'ef0f50fff37934cc88767e196cc4a6b92d9d46d7',
					'id' => '26x9738',
				),
				array(
					0 => 'Design',
					'servicename' => 'Design',
					1 => '9752',
					'serviceid' => '9752',
					2 => '9ad64a8f94fe7c23ee6abff1828e231ec17ae2a5',
					'cbuuid' => '9ad64a8f94fe7c23ee6abff1828e231ec17ae2a5',
					'id' => '26x9752',
				),
			),
		);
		$this->assertEquals($expected, $actual, 'Contacts-Services Quote');
		////////////////////////////
		$qparams = array(
			'productDiscriminator' => 'ProductLineInvoice',
			'columns' => 'servicename, id',
		);
		$actual = getRelatedRecords('12x1613', 'Contacts', 'Services', $qparams, $current_user);
		$expected= array(
			'records' => array(
			),
		);
		$this->assertEquals($expected, $actual, 'Contacts-Services Invoice');
		////////////////////////////
		$qparams = array(
			'productDiscriminator' => 'ProductLineAll',
			'columns' => 'servicename, id',
		);
		$actual = getRelatedRecords('12x1613', 'Contacts', 'Services', $qparams, $current_user);
		$expected= array(
			'records' => array(
				array(
					0 => 'Social and cultural event',
					'servicename' => 'Social and cultural event',
					1 => '9730',
					'serviceid' => '9730',
					2 => 'bcb11c59a702245bf8cd6c67b58de37b111c0b1e',
					'cbuuid' => 'bcb11c59a702245bf8cd6c67b58de37b111c0b1e',
					'id' => '26x9730',
				),
				array(
					0 => 'Set up computers, cell phones, and similar devices',
					'servicename' => 'Set up computers, cell phones, and similar devices',
					1 => '9738',
					'serviceid' => '9738',
					2 => 'ef0f50fff37934cc88767e196cc4a6b92d9d46d7',
					'cbuuid' => 'ef0f50fff37934cc88767e196cc4a6b92d9d46d7',
					'id' => '26x9738',
				),
				array(
					0 => 'Design',
					'servicename' => 'Design',
					1 => '9752',
					'serviceid' => '9752',
					2 => '9ad64a8f94fe7c23ee6abff1828e231ec17ae2a5',
					'cbuuid' => '9ad64a8f94fe7c23ee6abff1828e231ec17ae2a5',
					'id' => '26x9752',
				),
				array(
					0 => 'Investing',
					'servicename' => 'Investing',
					1 => '9713',
					'serviceid' => '9713',
					2 => 'd8827a99ae00c5ef9cda704173cdea5d042d39c3',
					'cbuuid' => 'd8827a99ae00c5ef9cda704173cdea5d042d39c3',
					'id' => '26x9713',
				),
				array(
					0 => 'Set up computers, cell phones, and similar devices',
					'servicename' => 'Set up computers, cell phones, and similar devices',
					1 => '9755',
					'serviceid' => '9755',
					2 => '60e70f186b72282a963338fbd4eab1ec9e8d04ea',
					'cbuuid' => '60e70f186b72282a963338fbd4eab1ec9e8d04ea',
					'id' => '26x9755',
				),
				array(
					0 => 'Bird-watching',
					'servicename' => 'Bird-watching',
					1 => '9722',
					'serviceid' => '9722',
					2 => 'b3fac938a788007f55ade8a65c0ebacc649012bd',
					'cbuuid' => 'b3fac938a788007f55ade8a65c0ebacc649012bd',
					'id' => '26x9722',
				),
			),
		);
		$this->assertEquals($expected, $actual, 'Contacts-Services All');
	}

	/**
	 * Method testProductsInvalidFieldAndMissingID
	 * @test
	 */
	public function testProductsInvalidFieldAndMissingID() {
		global $current_user;
		$qparams = array(
			'productDiscriminator' => 'ProductLineSalesOrder',
			'columns' => 'productname, doesnotexist',
		);
		$actual = getRelatedRecords('12x1613', 'Contacts', 'Products', $qparams, $current_user);
		$expected= array(
			'records' => array(
				array(
					0 => 'U8 Smart Watch',
					'productname' => 'U8 Smart Watch',
					1 => '9a3e0706ebf020baefab732a42f4940462ca1696',
					'cbuuid' => '9a3e0706ebf020baefab732a42f4940462ca1696',
					//'id' => '14x2632', I think these IDs should be here > fix?
				),
				array(
					0 => 'Protective Case Cover for iPhone 6',
					'productname' => 'Protective Case Cover for iPhone 6',
					1 => '668d624d92e450119f769142036e7e235ec030c7',
					'cbuuid' => '668d624d92e450119f769142036e7e235ec030c7',
					//'id' => '14x2618',
				),
				array(
					0 => 'New 3.3 Inch 9W Epistar LED Work Light',
					'productname' => 'New 3.3 Inch 9W Epistar LED Work Light',
					1 => '9b2f22ca7c009319b1e78f9778fc9f2df84a1aaf',
					'cbuuid' => '9b2f22ca7c009319b1e78f9778fc9f2df84a1aaf',
					//'id' => '14x2624',
				),
				array(
					0 => 'cheap in stock muti-color lipstick',
					'productname' => 'cheap in stock muti-color lipstick',
					1 => '321dcfe3e3d45e08441ed92d4a729786d36d26bf',
					'cbuuid' => '321dcfe3e3d45e08441ed92d4a729786d36d26bf',
					//'id' => '14x2622',
				),
				array(
					0 => 'Car Sunshade Windshield Cover / Car Snow Cover',
					'productname' => 'Car Sunshade Windshield Cover / Car Snow Cover',
					1 => '08b6499c06f49c16689928879243b21e61928a5c',
					'cbuuid' => '08b6499c06f49c16689928879243b21e61928a5c',
					//'id' => '14x2620',
				),
			),
		);
		$this->assertEquals($expected, $actual, 'Contacts-Products SO');
	}

	/**
	 * Method testIncorrectProductDiscriminator
	 * @test
	 */
	public function testIncorrectProductDiscriminator() {
		global $current_user;
		$qparams = array(
			'productDiscriminator' => 'ProductLineQuotes', // extra S
			'columns' => 'productname, id',
		);
		$actual = getRelatedRecords('12x1613', 'Contacts', 'Products', $qparams, $current_user);
		$expected= array(
			'records' => array(),
		);
		$this->assertEquals($expected, $actual, 'Contacts-Products Incorrect Discriminator');
	}

	/**
	 * Method testInvalidModuleGRR
	 * @test
	 * @expectedException WebServiceException
	 */
	public function testInvalidModuleGRR() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$ACCESSDENIED);
		getRelatedRecords('600x600', 'DoesNotExist', 'Products', array(), $current_user);
	}

	/**
	 * Method testActorModuleGRR
	 * @test
	 * @expectedException WebServiceException
	 */
	public function testActorModuleGRR() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$UNKNOWNENTITY);
		getRelatedRecords('600x600', 'Currency', 'Products', array(), $current_user);
	}

	/**
	 * Method testActorRelatedModuleGRR
	 * @test
	 * @expectedException WebServiceException
	 */
	public function testActorRelatedModuleGRR() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$UNKNOWNENTITY);
		getRelatedRecords('600x600', 'Products', 'Currency', array(), $current_user);
	}

	/**
	 * Method testNonEntityModuleGRR
	 * @test
	 * @expectedException WebServiceException
	 */
	public function testNonEntityModuleGRR() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$ACCESSDENIED);
		getRelatedRecords('600x600', 'evvtMenu', 'Products', array(), $current_user);
	}

	/**
	 * Method testNonEntityRelatedModuleGRR
	 * @test
	 * @expectedException WebServiceException
	 */
	public function testNonEntityRelatedModuleGRR() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$ACCESSDENIED);
		getRelatedRecords('600x600', 'Products', 'evvtMenu', array(), $current_user);
	}

	/**
	 * Method testInvalidModuleGRQ
	 * @test
	 * @expectedException WebServiceException
	 */
	public function testInvalidModuleGRQ() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$ACCESSDENIED);
		__getRLQuery('600x600', 'DoesNotExist', 'Products', array(), $current_user);
	}

	/**
	 * Method testActorModuleGRQ
	 * @test
	 * @expectedException WebServiceException
	 */
	public function testActorModuleGRQ() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$UNKNOWNENTITY);
		__getRLQuery('600x600', 'Currency', 'Products', array(), $current_user);
	}

	/**
	 * Method testActorRelatedModuleGRQ
	 * @test
	 * @expectedException WebServiceException
	 */
	public function testActorRelatedModuleGRQ() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$UNKNOWNENTITY);
		__getRLQuery('600x600', 'Products', 'Currency', array(), $current_user);
	}

	/**
	 * Method testNonEntityModuleGRQ
	 * @test
	 * @expectedException WebServiceException
	 */
	public function testNonEntityModuleGRQ() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$ACCESSDENIED);
		__getRLQuery('600x600', 'evvtMenu', 'Products', array(), $current_user);
	}

	/**
	 * Method testNonEntityRelatedModuleGRQ
	 * @test
	 * @expectedException WebServiceException
	 */
	public function testNonEntityRelatedModuleGRQ() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$ACCESSDENIED);
		__getRLQuery('600x600', 'Products', 'evvtMenu', array(), $current_user);
	}

	/**
	 * Method testNoPermissionModule
	 * @test
	 * @expectedException WebServiceException
	 */
	public function testNoPermissionModule() {
		global $current_user;
		$holduser = $current_user;
		$user = new Users();
		///  nocreate
		$user->retrieveCurrentUserInfoFromFile(11); // nocreate
		$current_user = $user;
		$pdoID = vtws_getEntityId('cbTermConditions');
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$ACCESSDENIED);
		try {
			getRelatedRecords($pdoID.'x27153', 'cbTermConditions', 'Documents', array(), $current_user);
		} catch (\Throwable $th) {
			$current_user = $holduser;
			throw $th;
		}
	}

	/**
	 * Method testNoPermissionRelatedModule
	 * @test
	 * @expectedException WebServiceException
	 */
	public function testNoPermissionRelatedModule() {
		global $current_user;
		$holduser = $current_user;
		$user = new Users();
		///  nocreate
		$user->retrieveCurrentUserInfoFromFile(11); // nocreate
		$current_user = $user;
		$pdoID = vtws_getEntityId('cbTermConditions');
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$ACCESSDENIED);
		try {
			getRelatedRecords($pdoID.'x27153', 'Invoice', 'cbTermConditions', array(), $current_user);
		} catch (\Throwable $th) {
			$current_user = $holduser;
			throw $th;
		}
	}

	/**
	 * Method testInvalidID
	 * @test
	 * @expectedException WebServiceException
	 */
	public function testInvalidID() {
		global $current_user;
		////////////////////////////
		$qparams = array(
			'productDiscriminator' => 'ProductLineSalesOrder',
			'columns' => 'productname, id',
		);
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$INVALIDID);
		// 12192 is a quote
		getRelatedRecords(vtws_getEntityId('SalesOrder').'x12192', 'SalesOrder', 'Products', $qparams, $current_user);
	}
}
?>