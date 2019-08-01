-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 31, 2019 at 05:11 PM
-- Server version: 5.7.27-0ubuntu0.18.04.1
-- PHP Version: 7.2.19-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `myhome_dev`
--

-- --------------------------------------------------------

--
-- Table structure for table `templates`
--


--
-- Dumping data for table `templates`
--

INSERT INTO `templates` (`id`, `category_id`, `type`, `name`, `subject`, `body`, `default`, `system`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 9, 1, 'User - new_admin', 'New admin created', '<p>Hello {{name}}</p>\n<p>A new admin account was created:</p>\n<p>User {{subjectName}}</p>\n<p>Email {{subjectEmail}}</p>', 1, 0, '2019-07-30 01:36:02', '2019-07-30 01:36:02', NULL),
(2, 10, 1, 'User - reset_password', 'Password reset request for your account', '<p>Hello {{title}} {{name}}</p>\n<p>You are receiving this email because we received a password reset request for your account.</p>\n<p>Reset Password {{passwordResetUrl}}</p><p>If you did not request a password reset, no further action is required.</p>', 1, 0, '2019-07-30 01:36:02', '2019-07-30 01:36:02', NULL),
(3, 11, 1, 'User - reset_password_success', 'Password changed successfully', '<p>You changed your password successfully.</p>\n<p>If you did change password, no further action is required.</p>\n<p>If you did not change password, protect your account.</p>', 1, 0, '2019-07-30 01:36:02', '2019-07-30 01:36:02', NULL),
(4, 12, 1, 'Tenant - tenant_credentials', 'Account created', '<p>Hello {{title}} {{name}}</p>\n<p>Your account was created.</p>\n<p>Here is an pdf with credentials.</p>', 1, 0, '2019-07-30 01:36:02', '2019-07-30 01:36:02', NULL),
(5, 13, 1, 'Post - pinned_post', 'New Pined post: {{title}}', '<p>Hello {{salutation}} {{name}},</p>\n<p>Title {{title}}.</p>\n<p>{{content}}.</p>\n<p>Use <a href=\"{{autologin}}\">this link</a> to view the announcement.</p>', 1, 0, '2019-07-30 01:36:02', '2019-07-30 01:36:02', NULL),
(6, 14, 1, 'Post - post_published', 'New post published {{authorSalutation}} {{authorName}}', '<p>Hello {{salutation}} {{name}},</p>\n<p>{{authorSalutation}} {{authorName}} published a new post.</p>\n<p><em>{{content}}</em></p>\n<p>Use <a href=\"{{autologin}}\">this link</a> to view the published post.</p>', 1, 0, '2019-07-30 01:36:02', '2019-07-30 01:36:02', NULL),
(7, 15, 1, 'Post - new_post', 'New tenant post', '<p>Hello {{salutation}} {{name}},</p>\n<p>Tenant {{subjectSalutation}} {{subjectName}} added a new post</p>\n<p>{{content}}.</p>\n<p>Use <a href=\"{{autologin}}\">this link</a> to view the published post.</p>', 1, 0, '2019-07-30 01:36:02', '2019-07-30 01:36:02', NULL),
(8, 16, 1, 'Post - post_liked', '{{likerSalutation}} {{likerName}} liked your post', '<p>Hello {{salutation}} {{name}},</p>\n<p>Tenant {{likerSalutation}} {{likerName}} liked your post:</p>\n<p>{{content}}.</p>\n<p>Use <a href=\"{{autologin}}\">this link</a> to view the liked post.</p>', 1, 0, '2019-07-30 01:36:02', '2019-07-30 01:36:02', NULL),
(9, 17, 1, 'Post - post_commented', '{{commenterSalutation}} {{commenterName}} commented on your post', '<p>Hello {{salutation}} {{name}},</p>\n<p>Tenant {{commenterSalutation}} {{commenterName}} commented on your post:</p>\n<p><em>{{comment}}</em>.</p>\n<p>Use <a href=\"{{autologin}}\">this link</a> to view the post.</p>', 1, 0, '2019-07-30 01:36:02', '2019-07-30 01:36:02', NULL),
(10, 18, 1, 'Post - post_new_tenant_in_neighbour', 'New tenant in the neighbour', '<p>Hello {{salutation}} {{name}},</p>\n<p>You got a new neighbour: {{subjectSalutation}} {{subjectName}}.</p>\n<p><em>{{content}}</em></p>\n<p>Use <a href=\"{{autologin}}\">this link</a> to view the post.</p>', 1, 0, '2019-07-30 01:36:02', '2019-07-30 01:36:02', NULL),
(11, 19, 1, 'Product - product_liked', '{{salutation}} {{name}} liked your post', '<p>Hello {{authorSalutation}} {{authorName}},</p>\n<p>Tenant {{salutation}} {{name}} liked your product:</p>\n<p>{{title}}.</p>\n<p>Use <a href=\"{{autologin}}\">this link</a> to view the product.</p>', 1, 0, '2019-07-30 01:36:02', '2019-07-30 01:36:02', NULL),
(12, 20, 1, 'Product - product_commented', '{{salutation}} {{name}} commented on your post', '<p>Hello {{authorSalutation}} {{authorName}},</p>\n<p>Tenant {{salutation}} {{name}} commented on  your product:</p>\n<p><em>{{title}}</em>.</p>\n<p>Comment:</p>\n<p><em>{{comment}}</em>.</p>\n<p>Use <a href=\"{{autologin}}\">this link</a> to view the product.</p>', 1, 0, '2019-07-30 01:36:02', '2019-07-30 01:36:02', NULL),
(13, 23, 1, 'Request - new_request', 'New Tenant request: {{title}}', '<p>Hello {{salutation}} {{name}},</p>\n<p>Tenant {{subjectSalutation}} {{subjectName}} created a new request</p>\n<p>Unit: {{category}}.</p>\n<p>Category: {{category}}.</p>\n<p>Title: {{title}}.</p>\n<p>{{description}}.</p>\n<p>Use <a href=\"{{autologin}}\">this link</a> to view the request.</p>', 1, 0, '2019-07-30 01:36:02', '2019-07-30 01:36:02', NULL),
(14, 24, 1, 'Request - communication_service_email', 'New assignment to request: {{title}}', '<p>Hello {{salutation}} {{name}},</p>\n<p>You have been assigned to an new request {{title}</p>\n<p>Category: {{category}}.</p>\n<p>Title: {{title}}.</p>\n<p>{{description}}.</p>', 1, 0, '2019-07-30 01:36:02', '2019-07-30 01:36:02', NULL),
(15, 25, 1, 'Request - request_comment', 'New comment for request: {{title}}', '<p>Hello {{salutation}} {{name}},</p>\n<p>A new comment by {{commenterSalutation}} {{commenterName}} was made for request: {{title}}</p>\n<p><em>{{comment}}</em>.</p>\n<p>Use <a href=\"{{autologin}}\">this link</a> to view the request.</p>', 1, 0, '2019-07-30 01:36:02', '2019-07-30 01:36:02', NULL),
(16, 26, 1, 'Request - request_upload', '{{uploaderSalutation}} {{uploaderName}} uploaded a new document for request: {{title}}', '<p>Hello {{receiverSalutation}} {{receiverName}},</p>\n<p>{{uploaderSalutation}} {{uploaderName}} uploaded a new document for request: {{title}}.</p>\n<p>Please find the uploaded file in the attachments of this email.</p>\n<p>Use <a href=\"{{autologin}}\">this link</a> to view the request.</p>', 1, 0, '2019-07-30 01:36:02', '2019-07-30 01:36:02', NULL),
(17, 27, 1, 'Request - request_admin_change_status', 'Status changed for request: {{title}}', '<p>Hello {{salutation}} {{name}},</p>\n<p>Admin changed status for request {{title}} from {{originalStatus}} to {{status}}</p>\n<p>Use <a href=\"{{autologin}}\">this link</a> to view the request.</p>', 1, 0, '2019-07-30 01:36:02', '2019-07-30 01:36:02', NULL),
(18, 28, 1, 'Request - request_internal_comment', 'New internal comment for request: {{title}}', '<p>Hello {{receiverSalutation}} {{receiverName}},</p>\n<p>{{senderSalutation}} {{senderName}} added a new private comment for request: {{title}}</p>\n<p><em>{{comment}}.</em></p>\n<p>Use <a href=\"{{autologin}}\">this link</a> to view the request.</p>', 1, 0, '2019-07-30 01:36:02', '2019-07-30 01:36:02', NULL),
(19, 29, 1, 'Request - request_due_date_reminder', 'Request: {{title}} is approaching its due date', '<p>Hello {{salutation}} {{name}},</p>\n<p>Due date for request {{title}} is {{dueDate}}</p>\n<p>Use <a href=\"{{autologin}}\">this link</a> to view the request.</p>', 1, 0, '2019-07-30 01:36:02', '2019-07-30 01:36:02', NULL),
(20, 30, 1, 'Cleanify_request - cleanify_request_email', 'New Cleanify request from: {{salutation}} {{firstName}} {{lastName}}', '<p>New Cleanify request,</p>\n<p>Name : {{salutation}} {{firstName}} {{lastName}}.</p>\n<p>Phone : {{phone}}.</p>\n<p>Email : {{email}}.</p>\n<p>Address:</p>\n<p>{{address}}, {{city}} {{zip}}.</p>', 1, 0, '2019-07-30 01:36:02', '2019-07-30 01:36:02', NULL),
(21, 21, 1, 'Grreting 1', 'Hello {{subjectSalutation}} {{subjectName}}. How can I help you?', '', 1, 0, '2019-07-30 01:36:02', '2019-07-30 01:36:02', NULL),
(22, 21, 1, 'Grreting 2', 'Hello {{subjectSalutation}} {{subjectName}}. My name is {{name}} How can I help you?', '', 1, 0, '2019-07-30 01:36:02', '2019-07-30 01:36:02', NULL),
(23, 21, 1, 'Goodbye 1', 'Have a nice day {{subjectSalutation}} {{subjectName}}.', '', 1, 0, '2019-07-30 01:36:02', '2019-07-30 01:36:02', NULL),
(24, 22, 1, 'Service Grreting 1', 'Hello {{subjectSalutation}} {{subjectName}}. How can I help you?', '', 1, 0, '2019-07-30 01:36:02', '2019-07-30 01:36:02', NULL),
(25, 22, 1, 'Service Grreting 2', 'Hello {{subjectSalutation}} {{subjectName}}. My name is {{name}} How can I help you?', '', 1, 0, '2019-07-30 01:36:02', '2019-07-30 01:36:02', NULL),
(26, 22, 1, 'Service Goodbye 1', 'Have a nice day {{subjectSalutation}} {{subjectName}}.', '', 1, 0, '2019-07-30 01:36:02', '2019-07-30 01:36:02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `template_categories`
--

--
-- Dumping data for table `template_categories`
--

INSERT INTO `template_categories` (`id`, `parent_id`, `name`, `description`, `subject`, `body`, `tag_map`, `created_at`, `updated_at`, `deleted_at`, `type`, `system`) VALUES
(1, NULL, 'user', '', '', '', NULL, '2019-07-30 01:36:01', '2019-07-30 01:36:01', NULL, 1, 0),
(2, NULL, 'tenant', '', '', '', NULL, '2019-07-30 01:36:01', '2019-07-30 01:36:01', NULL, 1, 0),
(3, NULL, 'post', '', '', '', NULL, '2019-07-30 01:36:01', '2019-07-30 01:36:01', NULL, 1, 0),
(4, NULL, 'product', '', '', '', NULL, '2019-07-30 01:36:01', '2019-07-30 01:36:01', NULL, 1, 0),
(5, NULL, 'request', '', '', '', NULL, '2019-07-30 01:36:01', '2019-07-30 01:36:01', NULL, 1, 0),
(6, NULL, 'manager', '', '', '', NULL, '2019-07-30 01:36:01', '2019-07-30 01:36:01', NULL, 1, 0),
(7, NULL, 'service_provider', '', '', '', NULL, '2019-07-30 01:36:01', '2019-07-30 01:36:01', NULL, 1, 0),
(8, NULL, 'cleanify_request', '', '', '', NULL, '2019-07-30 01:36:01', '2019-07-30 01:36:01', NULL, 1, 0),
(9, 1, 'new_admin', 'User create admin notification', 'New admin created', '<p>Hello {{name}}</p>\n<p>A new admin account was created:</p>\n<p>User {{subjectName}}</p>\n<p>Email {{subjectEmail}}</p>', '{\"name\":\"user.name\",\"email\":\"user.email\",\"phone\":\"user.phone\",\"title\":\"constant.user.title\",\"subjectName\":\"subject.name\",\"subjectEmail\":\"subject.email\",\"subjectPhone\":\"subject.phone\",\"subjectTitle\":\"constant.subject.title\"}', '2019-07-30 01:36:01', '2019-07-30 01:36:01', NULL, 1, 1),
(10, 1, 'reset_password', 'User reset password email', 'Password reset request for your account', '<p>Hello {{title}} {{name}}</p>\n<p>You are receiving this email because we received a password reset request for your account.</p>\n<p>Reset Password {{passwordResetUrl}}</p><p>If you did not request a password reset, no further action is required.</p>', '{\"name\":\"user.name\",\"email\":\"user.email\",\"phone\":\"user.phone\",\"title\":\"constant.user.title\",\"passwordResetUrl\":\"passwordResetUrl\"}', '2019-07-30 01:36:01', '2019-07-30 01:36:01', NULL, 1, 1),
(11, 1, 'reset_password_success', 'Password changed successfully', 'Password changed successfully', '<p>You changed your password successfully.</p>\n<p>If you did change password, no further action is required.</p>\n<p>If you did not change password, protect your account.</p>', '{\"name\":\"user.name\",\"email\":\"user.email\",\"phone\":\"user.phone\",\"title\":\"constant.user.title\"}', '2019-07-30 01:36:01', '2019-07-30 01:36:01', NULL, 1, 1),
(12, 2, 'tenant_credentials', 'Email sent to tenant, containing the PDF with the credentials and tenancy details.', 'Account created', '<p>Hello {{title}} {{name}}</p>\n<p>Your account was created.</p>\n<p>Here is an pdf with credentials.</p>', '{\"name\":\"user.name\",\"birthDate\":\"tenant.birthDate\",\"mobilePhone\":\"tenant.mobile_phone\",\"privatePhone\":\"tenant.private_phone\",\"email\":\"tenant.email\",\"phone\":\"tenant.phone\",\"title\":\"constant.tenant.title\",\"tenantCredentials\":\"tenantCredentials\"}', '2019-07-30 01:36:01', '2019-07-30 01:36:01', NULL, 1, 1),
(13, 3, 'pinned_post', 'Email sent to tenants when admin publishes a pinned post', 'New Pined post: {{title}}', '<p>Hello {{salutation}} {{name}},</p>\n<p>Title {{title}}.</p>\n<p>{{content}}.</p>\n<p>Use <a href=\"{{autologin}}\">this link</a> to view the announcement.</p>', '{\"salutation\":\"user.title\",\"name\":\"user.name\",\"title\":\"post.title\",\"content\":\"post.content\",\"execution_start\":\"post.executionStartStr\",\"execution_end\":\"post.executionEndStr\",\"category\":\"post.categoryStr\",\"providers\":\"post.providersStr\",\"buildings\":\"post.buildingsStr\",\"districts\":\"post.districtsStr\",\"autologin\":\"user.autologinUrl\"}', '2019-07-30 01:36:01', '2019-07-30 01:36:01', NULL, 1, 1),
(14, 3, 'post_published', 'Email sent to neighbour tenants when admin publishes a post, or the post is automatically published', 'New post published {{authorSalutation}} {{authorName}}', '<p>Hello {{salutation}} {{name}},</p>\n<p>{{authorSalutation}} {{authorName}} published a new post.</p>\n<p><em>{{content}}</em></p>\n<p>Use <a href=\"{{autologin}}\">this link</a> to view the published post.</p>', '{\"authorSalutation\":\"post.user.title\",\"authorName\":\"post.user.name\",\"salutation\":\"receiver.title\",\"name\":\"receiver.name\",\"content\":\"post.content\",\"autologin\":\"receiver.autologinUrl\"}', '2019-07-30 01:36:01', '2019-07-30 01:36:01', NULL, 1, 1),
(15, 3, 'new_post', 'Email sent to admins when tenant creates a new post', 'New tenant post', '<p>Hello {{salutation}} {{name}},</p>\n<p>Tenant {{subjectSalutation}} {{subjectName}} added a new post</p>\n<p>{{content}}.</p>\n<p>Use <a href=\"{{autologin}}\">this link</a> to view the published post.</p>', '{\"salutation\":\"user.title\",\"name\":\"user.name\",\"subjectSalutation\":\"subject.title\",\"subjectName\":\"subject.name\",\"content\":\"post.content\",\"type\":\"post.type\",\"autologin\":\"user.autologinUrl\"}', '2019-07-30 01:36:01', '2019-07-30 01:36:01', NULL, 1, 1),
(16, 3, 'post_liked', 'Email sent to post author when tenant liked the post', '{{likerSalutation}} {{likerName}} liked your post', '<p>Hello {{salutation}} {{name}},</p>\n<p>Tenant {{likerSalutation}} {{likerName}} liked your post:</p>\n<p>{{content}}.</p>\n<p>Use <a href=\"{{autologin}}\">this link</a> to view the liked post.</p>', '{\"salutation\":\"post.user.title\",\"name\":\"post.user.name\",\"likerSalutation\":\"user.title\",\"likerName\":\"user.name\",\"content\":\"post.content\",\"autologin\":\"post.user.autologinUrl\"}', '2019-07-30 01:36:01', '2019-07-30 01:36:01', NULL, 1, 1),
(17, 3, 'post_commented', 'Email sent to post author when tenant comments on the post', '{{commenterSalutation}} {{commenterName}} commented on your post', '<p>Hello {{salutation}} {{name}},</p>\n<p>Tenant {{commenterSalutation}} {{commenterName}} commented on your post:</p>\n<p><em>{{comment}}</em>.</p>\n<p>Use <a href=\"{{autologin}}\">this link</a> to view the post.</p>', '{\"salutation\":\"post.user.title\",\"name\":\"post.user.name\",\"commenterSalutation\":\"user.title\",\"commenterName\":\"user.name\",\"content\":\"post.content\",\"comment\":\"comment.comment\",\"autologin\":\"post.user.autologinUrl\"}', '2019-07-30 01:36:01', '2019-07-30 01:36:01', NULL, 1, 1),
(18, 3, 'post_new_tenant_in_neighbour', 'Email sent to neighbour tenants when new neighbour moves in the neighbourhood', 'New tenant in the neighbour', '<p>Hello {{salutation}} {{name}},</p>\n<p>You got a new neighbour: {{subjectSalutation}} {{subjectName}}.</p>\n<p><em>{{content}}</em></p>\n<p>Use <a href=\"{{autologin}}\">this link</a> to view the post.</p>', '{\"subjectSalutation\":\"post.user.title\",\"subjectName\":\"post.user.name\",\"salutation\":\"receiver.title\",\"name\":\"receiver.name\",\"content\":\"post.content\",\"autologin\":\"receiver.autologinUrl\"}', '2019-07-30 01:36:01', '2019-07-30 01:36:01', NULL, 1, 1),
(19, 4, 'product_liked', 'Email sent to product author when tenant liked the product in marketplace', '{{salutation}} {{name}} liked your post', '<p>Hello {{authorSalutation}} {{authorName}},</p>\n<p>Tenant {{salutation}} {{name}} liked your product:</p>\n<p>{{title}}.</p>\n<p>Use <a href=\"{{autologin}}\">this link</a> to view the product.</p>', '{\"salutation\":\"user.title\",\"name\":\"user.name\",\"authorSalutation\":\"product.user.title\",\"authorName\":\"product.user.name\",\"title\":\"product.title\",\"type\":\"product.type\",\"autologin\":\"product.user.autologinUrl\"}', '2019-07-30 01:36:01', '2019-07-30 01:36:01', NULL, 1, 0),
(20, 4, 'product_commented', 'Email sent to product author when tenant comments on the product', '{{salutation}} {{name}} commented on your post', '<p>Hello {{authorSalutation}} {{authorName}},</p>\n<p>Tenant {{salutation}} {{name}} commented on  your product:</p>\n<p><em>{{title}}</em>.</p>\n<p>Comment:</p>\n<p><em>{{comment}}</em>.</p>\n<p>Use <a href=\"{{autologin}}\">this link</a> to view the product.</p>', '{\"salutation\":\"user.title\",\"name\":\"user.name\",\"authorSalutation\":\"product.user.title\",\"authorName\":\"product.user.name\",\"title\":\"product.title\",\"type\":\"product.type\",\"comment\":\"comment.comment\",\"autologin\":\"product.user.autologinUrl\"}', '2019-07-30 01:36:01', '2019-07-30 01:36:01', NULL, 1, 0),
(21, 5, 'communication_tenant', 'Request Tenant communication templates', 'Hello {{subjectSalutation}} {{subjectName}}', '', '{\"salutation\":\"user.title\",\"name\":\"user.name\",\"subjectSalutation\":\"subject.title\",\"subjectName\":\"subject.name\",\"title\":\"request.title\",\"description\":\"request.description\",\"category\":\"request.category.name\",\"unit\":\"request.unit.name\",\"building\":\"request.unit.building.name\"}', '2019-07-30 01:36:01', '2019-07-30 01:36:01', NULL, 2, 0),
(22, 5, 'communication_service_chat', 'Request Service providers communication templates', 'Hello {{subjectSalutation}} {{subjectName}}', '', '{\"salutation\":\"user.title\",\"name\":\"user.name\",\"subjectSalutation\":\"subject.title\",\"subjectName\":\"subject.name\",\"title\":\"request.title\",\"description\":\"request.description\",\"category\":\"request.category.name\",\"unit\":\"request.unit.name\",\"building\":\"request.unit.building.name\"}', '2019-07-30 01:36:01', '2019-07-30 01:36:01', NULL, 2, 0),
(23, 5, 'new_request', 'Email sent to property managers when tenant creates a new request.', 'New Tenant request: {{title}}', '<p>Hello {{salutation}} {{name}},</p>\n<p>Tenant {{subjectSalutation}} {{subjectName}} created a new request</p>\n<p>Unit: {{category}}.</p>\n<p>Category: {{category}}.</p>\n<p>Title: {{title}}.</p>\n<p>{{description}}.</p>\n<p>Use <a href=\"{{autologin}}\">this link</a> to view the request.</p>', '{\"salutation\":\"user.title\",\"name\":\"user.name\",\"subjectSalutation\":\"subject.title\",\"subjectName\":\"subject.name\",\"title\":\"request.title\",\"description\":\"request.description\",\"category\":\"request.category.name\",\"unit\":\"request.unit.name\",\"building\":\"request.unit.building.name\",\"autologin\":\"user.autologinUrl\"}', '2019-07-30 01:36:01', '2019-07-30 01:36:01', NULL, 1, 1),
(24, 5, 'communication_service_email', 'Notify service provider -> sends email to service provider and others (BCC, CC).', 'New assignment to request: {{title}}', '<p>Hello {{salutation}} {{name}},</p>\n<p>You have been assigned to an new request {{title}</p>\n<p>Category: {{category}}.</p>\n<p>Title: {{title}}.</p>\n<p>{{description}}.</p>', '{\"salutation\":\"user.title\",\"name\":\"user.name\",\"subjectSalutation\":\"subject.title\",\"subjectName\":\"subject.name\",\"title\":\"request.title\",\"description\":\"request.description\",\"category\":\"request.category.name\"}', '2019-07-30 01:36:01', '2019-07-30 01:36:01', NULL, 1, 0),
(25, 5, 'request_comment', 'When any party adds a new comment (tenant, property manager, service partner, admin or super admin) we notify all assigned people', 'New comment for request: {{title}}', '<p>Hello {{salutation}} {{name}},</p>\n<p>A new comment by {{commenterSalutation}} {{commenterName}} was made for request: {{title}}</p>\n<p><em>{{comment}}</em>.</p>\n<p>Use <a href=\"{{autologin}}\">this link</a> to view the request.</p>', '{\"salutation\":\"user.title\",\"name\":\"user.name\",\"commenterSalutation\":\"comment.user.title\",\"commenterName\":\"comment.user.name\",\"title\":\"request.title\",\"description\":\"request.description\",\"category\":\"request.category.name\",\"comment\":\"comment.comment\",\"autologin\":\"user.autologinUrl\"}', '2019-07-30 01:36:01', '2019-07-30 01:36:01', NULL, 1, 0),
(26, 5, 'request_upload', 'When any party uploads a document/image', '{{uploaderSalutation}} {{uploaderName}} uploaded a new document for request: {{title}}', '<p>Hello {{receiverSalutation}} {{receiverName}},</p>\n<p>{{uploaderSalutation}} {{uploaderName}} uploaded a new document for request: {{title}}.</p>\n<p>Please find the uploaded file in the attachments of this email.</p>\n<p>Use <a href=\"{{autologin}}\">this link</a> to view the request.</p>', '{\"receiverSalutation\":\"receiver.title\",\"receiverName\":\"receiver.name\",\"uploaderSalutation\":\"uploader.title\",\"uploaderName\":\"uploader.name\",\"title\":\"request.title\",\"description\":\"request.description\",\"category\":\"request.category.name\",\"autologin\":\"receiver.autologinUrl\"}', '2019-07-30 01:36:01', '2019-07-30 01:36:01', NULL, 1, 0),
(27, 5, 'request_admin_change_status', 'When the Property Manager, Admin or Service partner change the status we notify the tenant, each time when status is changed from X to XY', 'Status changed for request: {{title}}', '<p>Hello {{salutation}} {{name}},</p>\n<p>Admin changed status for request {{title}} from {{originalStatus}} to {{status}}</p>\n<p>Use <a href=\"{{autologin}}\">this link</a> to view the request.</p>', '{\"salutation\":\"request.tenant.title\",\"name\":\"request.tenant.user.name\",\"title\":\"request.title\",\"description\":\"request.description\",\"category\":\"request.category.name\",\"status\":\"constant.request.status\",\"originalStatus\":\"constant.originalRequest.status\",\"autologin\":\"request.tenant.user.autologinUrl\"}', '2019-07-30 01:36:01', '2019-07-30 01:36:01', NULL, 1, 0),
(28, 5, 'request_internal_comment', 'When admin or service partner add a internal comment, we will notify each other.', 'New internal comment for request: {{title}}', '<p>Hello {{receiverSalutation}} {{receiverName}},</p>\n<p>{{senderSalutation}} {{senderName}} added a new private comment for request: {{title}}</p>\n<p><em>{{comment}}.</em></p>\n<p>Use <a href=\"{{autologin}}\">this link</a> to view the request.</p>', '{\"receiverSalutation\":\"receiver.title\",\"receiverName\":\"receiver.name\",\"senderSalutation\":\"sender.title\",\"senderName\":\"sender.name\",\"title\":\"request.title\",\"description\":\"request.description\",\"category\":\"request.category.name\",\"comment\":\"comment.comment\",\"autologin\":\"receiver.autologinUrl\"}', '2019-07-30 01:36:01', '2019-07-30 01:36:01', NULL, 1, 0),
(29, 5, 'request_due_date_reminder', 'Send reminder email to property manager / admin 1 day before the due date is reached', 'Request: {{title}} is approaching its due date', '<p>Hello {{salutation}} {{name}},</p>\n<p>Due date for request {{title}} is {{dueDate}}</p>\n<p>Use <a href=\"{{autologin}}\">this link</a> to view the request.</p>', '{\"salutation\":\"receiver.title\",\"name\":\"receiver.name\",\"title\":\"request.title\",\"description\":\"request.description\",\"dueDate\":\"request.due_date\",\"category\":\"request.category.name\",\"autologin\":\"receiver.autologinUrl\"}', '2019-07-30 01:36:01', '2019-07-30 01:36:01', NULL, 1, 0),
(30, 8, 'cleanify_request_email', 'Email sent to Cleanify when the tenant makes a request.', 'New Cleanify request from: {{salutation}} {{firstName}} {{lastName}}', '<p>New Cleanify request,</p>\n<p>Name : {{salutation}} {{firstName}} {{lastName}}.</p>\n<p>Phone : {{phone}}.</p>\n<p>Email : {{email}}.</p>\n<p>Address:</p>\n<p>{{address}}, {{city}} {{zip}}.</p>', '{\"salutation\":\"form.title\",\"firstName\":\"form.first_name\",\"lastName\":\"form.last_name\",\"address\":\"form.address\",\"zip\":\"form.zip\",\"city\":\"form.city\",\"email\":\"form.email\",\"phone\":\"form.phone\"}', '2019-07-30 01:36:01', '2019-07-30 01:36:01', NULL, 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `templates`
--
ALTER TABLE `templates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `templates_category_id_foreign` (`category_id`);

--
-- Indexes for table `template_categories`
--
ALTER TABLE `template_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `template_categories_parent_id_foreign` (`parent_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `templates`
--
ALTER TABLE `templates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `template_categories`
--
ALTER TABLE `template_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `templates`
--
ALTER TABLE `templates`
  ADD CONSTRAINT `templates_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `template_categories` (`id`);

--
-- Constraints for table `template_categories`
--
ALTER TABLE `template_categories`
  ADD CONSTRAINT `template_categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `template_categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
