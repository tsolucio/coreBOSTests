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
						),
					),
				),
				'Accounts Modcomments'
			),
			array(
				'11x421', 'Accounts', 'ModComments', array('productDiscriminator'=>''), 1, array('records' => array()),'Accounts Modcomments No Comments'
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
		$this->assertEquals($expected, $actual, $msg);
		$current_user = $holduser;
	}

	/**
	 * Method testMissingCombinations
	 * @test
	 */
	public function testUpdateWithWrongValues() {
		$this->markTestIncomplete(
			'This test needs more testing, especially all the different products combinations.'
		);
	}
}
?>