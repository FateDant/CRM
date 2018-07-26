CREATE DATABASE  IF NOT EXISTS `zsdj_crm` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_bin */;
USE `zsdj_crm`;


DROP TABLE IF EXISTS `f_channel`;
CREATE TABLE `f_channel` (
  `channel_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '渠道编号',
  `channel_name` varchar(40) COLLATE utf8_bin NOT NULL COMMENT '渠道名称',
  `channel_category` enum('常规招生','院校招生','口碑招生','校区招生') COLLATE utf8_bin NOT NULL COMMENT '渠道分类',
  `channel_desc` varchar(100) COLLATE utf8_bin DEFAULT NULL COMMENT '渠道描述',
  PRIMARY KEY (`channel_id`),
  UNIQUE KEY `UNQ_CHANNEL_NAME` (`channel_name`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='招生渠道表';


LOCK TABLES `f_channel` WRITE;
/*!40000 ALTER TABLE `f_channel` DISABLE KEYS */;
INSERT INTO `f_channel` VALUES (1,'百度','常规招生',NULL),(2,'360','常规招生',NULL),(3,'搜狗','常规招生',NULL),(4,'58同城','常规招生',NULL),(5,'赶集网','常规招生',NULL),(6,'智联招聘','常规招生',NULL),(7,'前程无忧','常规招生',NULL),(8,'院校招聘','院校招生',NULL),(9,'院校宣讲','院校招生',NULL),(10,'院校实训','院校招生',NULL),(11,'院校专业共建','院校招生',NULL),(12,'渠道代理','校区招生',NULL);
/*!40000 ALTER TABLE `f_channel` ENABLE KEYS */;
UNLOCK TABLES;


DROP TABLE IF EXISTS `f_course`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `f_course` (
  `course_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '课程编号',
  `course_name` varchar(40) COLLATE utf8_bin NOT NULL COMMENT '课程名称',
  `course_desc` varchar(100) COLLATE utf8_bin DEFAULT NULL COMMENT '课程说明',
  PRIMARY KEY (`course_id`),
  UNIQUE KEY `UNQ_COURSE_NAME` (`course_name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='课程名称表';


LOCK TABLES `f_course` WRITE;
/*!40000 ALTER TABLE `f_course` DISABLE KEYS */;
INSERT INTO `f_course` VALUES (1,'电子竞技运动与管理专业','电子竞技运动与管理专业'),(2,'电竞视频剪辑与合成专业','电子竞技视频的剪辑与合成'),(3,'电子竞技主播与解说专业','专业电子竞技主播与解说'),(4,'电子竞技运动训练营','电子竞技运动训练营');
/*!40000 ALTER TABLE `f_course` ENABLE KEYS */;
UNLOCK TABLES;


DROP TABLE IF EXISTS `f_privilege`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `f_privilege` (
  `priv_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '权限编号',
  `priv_name` varchar(40) COLLATE utf8_bin NOT NULL COMMENT '权限名称',
  PRIMARY KEY (`priv_id`),
  UNIQUE KEY `UNQ_PRIV` (`priv_name`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='权限表，根据模块功能进行划分，包括查询、增加、更新、删除等';


LOCK TABLES `f_privilege` WRITE;
/*!40000 ALTER TABLE `f_privilege` DISABLE KEYS */;
INSERT INTO `f_privilege` VALUES (1,'总部查询'),(3,'校区学生信息录入'),(4,'校区学生信息编辑'),(2,'校区查询'),(7,'用户信息修改'),(8,'用户信息删除'),(6,'用户信息增加'),(5,'用户信息查询');
/*!40000 ALTER TABLE `f_privilege` ENABLE KEYS */;
UNLOCK TABLES;


DROP TABLE IF EXISTS `f_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `f_role` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '角色编号',
  `role_name` varchar(40) COLLATE utf8_bin NOT NULL COMMENT '角色名称',
  `role_desc` varchar(100) COLLATE utf8_bin DEFAULT NULL COMMENT '角色说明',
  PRIMARY KEY (`role_id`),
  UNIQUE KEY `UNQ_ROLE` (`role_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='角色表';


LOCK TABLES `f_role` WRITE;
/*!40000 ALTER TABLE `f_role` DISABLE KEYS */;
/*!40000 ALTER TABLE `f_role` ENABLE KEYS */;
UNLOCK TABLES;


DROP TABLE IF EXISTS `f_school`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `f_school` (
  `school_id` int(11) NOT NULL AUTO_INCREMENT,
  `school_name` varchar(50) COLLATE utf8_bin NOT NULL,
  `school_desc` varchar(100) COLLATE utf8_bin DEFAULT NULL COMMENT '校区说明',
  PRIMARY KEY (`school_id`),
  UNIQUE KEY `UNQ_SCHOOL` (`school_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='校区分类表';

LOCK TABLES `f_school` WRITE;
INSERT INTO `f_school` VALUE(1,'nj','nnnn');
/*!40000 ALTER TABLE `f_school` DISABLE KEYS */;
/*!40000 ALTER TABLE `f_school` ENABLE KEYS */;
UNLOCK TABLES;


DROP TABLE IF EXISTS `f_student`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `f_student` (
  `student_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '学员编号',
  `student_name` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '学员姓名',
  `gender` enum('男','女','保密') COLLATE utf8_bin NOT NULL DEFAULT '保密' COMMENT '性别(男，女，保密)',
  `education` enum('初中','中专','高中','高职','大专','本科','研究生','未选择') COLLATE utf8_bin NOT NULL DEFAULT '未选择' COMMENT '学历(初中，中专，高中，高职，大专，本科，研究生，未选择)',
  `mobile` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '手机号',
  `qq` varchar(20) COLLATE utf8_bin DEFAULT NULL COMMENT 'qq账号',
  `wechat` varchar(20) COLLATE utf8_bin DEFAULT NULL COMMENT '微信号',
  `current_state` enum('在读学校','在读离校','待业','在职','自由职业','未选择') COLLATE utf8_bin NOT NULL DEFAULT '未选择' COMMENT '学员当前状态(在读学校，在读离校，待业，在职，自由职业，未选择)\n',
  `location` varchar(50) COLLATE utf8_bin NOT NULL DEFAULT '未选择' COMMENT '学员所在位置',
  `channel_id` int(11) DEFAULT NULL COMMENT '招生渠道编号',
  `online_consultant_id` int(11) DEFAULT NULL COMMENT '在线咨询师编号',
  `course_consultant_id` int(11) DEFAULT NULL COMMENT '课程顾问编号',
  `school_id` int(11) NOT NULL COMMENT '校区编号',
  `first_visit_time` datetime DEFAULT NULL COMMENT '上门时间 (首次拜访时间)',
  `register_time` datetime DEFAULT NULL COMMENT '报名时间',
  `course_id` int(11) DEFAULT NULL,
  `register_amount` double DEFAULT NULL COMMENT '报名金额',
  `visit_state` enum('未上门','已上门','已报名') COLLATE utf8_bin NOT NULL DEFAULT '未上门' COMMENT '回访状态(''未上门'', ''已上门'', ''已报名'')',
  `will_state` enum('非常有意向','一般有意向','意向不明','无意向') COLLATE utf8_bin NOT NULL DEFAULT '意向不明' COMMENT '意向状态(非常有意向，一般有意向，意向不明，无意向)',
  `desc` varchar(100) COLLATE utf8_bin DEFAULT NULL COMMENT '学员备注',
  `create_id` int(11) NOT NULL COMMENT '创建者姓名编号',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `last_update_id` int(11) NOT NULL COMMENT '最后更新者姓名编号',
  `last_update_time` datetime NOT NULL COMMENT '最后更新时间',
  PRIMARY KEY (`student_id`),
  KEY `FK_SCHOOL_STU` (`school_id`),
  KEY `FK_COURSE_STU` (`course_id`),
  KEY `FK_CHANNEL_STU_idx` (`channel_id`),
  CONSTRAINT `FK_CHANNEL_STU` FOREIGN KEY (`channel_id`) REFERENCES `f_channel` (`channel_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_COURSE_STU` FOREIGN KEY (`course_id`) REFERENCES `f_course` (`course_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_COUR_CONSUL_STU` FOREIGN KEY (`student_id`) REFERENCES `f_user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_CREATE_STU` FOREIGN KEY (`student_id`) REFERENCES `f_user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_ONL_CONSUL_STU` FOREIGN KEY (`student_id`) REFERENCES `f_user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_SCHOOL_STU` FOREIGN KEY (`school_id`) REFERENCES `f_school` (`school_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_UPDATE_STU` FOREIGN KEY (`student_id`) REFERENCES `f_user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='学员基本信息表';


LOCK TABLES `f_student` WRITE;
/*!40000 ALTER TABLE `f_student` DISABLE KEYS */;
/*!40000 ALTER TABLE `f_student` ENABLE KEYS */;
UNLOCK TABLES;


DROP TABLE IF EXISTS `f_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `f_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户编号',
  `user_name` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '用户登录名',
  `gender` enum('男','女','保密') COLLATE utf8_bin NOT NULL COMMENT '用户性别',
  `pwd` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '用于存放加密后的用户密码',
  `emp_name` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '员工真实姓名',
  `email` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '用户邮箱',
  `mobile` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '手机号',
  `desc` varchar(100) COLLATE utf8_bin DEFAULT NULL COMMENT '用户描述',
  `school_id` int(11) NOT NULL COMMENT '校区编号',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `UNQ_USER_NAME` (`user_name`),
  KEY `FK_SCHOOL_USER` (`school_id`),
  CONSTRAINT `FK_SCHOOL` FOREIGN KEY (`school_id`) REFERENCES `f_school` (`school_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='用户登记表';

INSERT INTO `f_user` VALUES (1,'admin','男','e96df7802d440c8fbf5f8a9e9f10bf68','zqy','133283@qq.com','112233445566','aaa','1');
INSERT INTO `f_user` VALUES (2,'fate','女','e10adc3949ba59abbe56e057f20f883e','xiaozhu','342324@qq.com','133423445566','bbb','1');


LOCK TABLES `f_user` WRITE;
/*!40000 ALTER TABLE `f_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `f_user` ENABLE KEYS */;
UNLOCK TABLES;


DROP TABLE IF EXISTS `log_op`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_op` (
  `op_log_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '日志编码',
  `op_type` enum('查询','增加','更改','删除') COLLATE utf8_bin NOT NULL COMMENT '操作类型(查询,增加,更新,删除)',
  `op_content` varchar(400) COLLATE utf8_bin NOT NULL COMMENT '操作内容(保存操作的SQL语句,针对增加,更新和删除操作)',
  `create_id` int(11) NOT NULL COMMENT '操作者用户编号',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`op_log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='操作日志';


LOCK TABLES `log_op` WRITE;
/*!40000 ALTER TABLE `log_op` DISABLE KEYS */;
/*!40000 ALTER TABLE `log_op` ENABLE KEYS */;
UNLOCK TABLES;


DROP TABLE IF EXISTS `log_visit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_visit` (
  `visit_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '回访记录编号',
  `visit_time` datetime NOT NULL COMMENT '回访时间',
  `visit_way` enum('电话','微信','QQ','当面') COLLATE utf8_bin NOT NULL COMMENT '回访方式',
  `will_state` enum('非常有意向','一般有意向','意向不明','无意向') COLLATE utf8_bin NOT NULL DEFAULT '意向不明' COMMENT '学员意向',
  `log_detail` varchar(400) COLLATE utf8_bin NOT NULL COMMENT '回访记录明细',
  `student_id` int(11) NOT NULL COMMENT '学员编号',
  `create_id` int(11) NOT NULL COMMENT '创建用户编号',
  `create_time` datetime NOT NULL,
  PRIMARY KEY (`visit_id`),
  KEY `FK_LV_STUDENT_idx` (`student_id`),
  KEY `FK_LV_CREATE_idx` (`create_id`),
  CONSTRAINT `FK_LV_CREATE` FOREIGN KEY (`create_id`) REFERENCES `f_user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_LV_STUDENT` FOREIGN KEY (`student_id`) REFERENCES `f_student` (`student_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='学员回访信息表';
/*!40101 SET character_set_client = @saved_cs_client */;


LOCK TABLES `log_visit` WRITE;
/*!40000 ALTER TABLE `log_visit` DISABLE KEYS */;
/*!40000 ALTER TABLE `log_visit` ENABLE KEYS */;
UNLOCK TABLES;


DROP TABLE IF EXISTS `ref_role_priv`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_role_priv` (
  `role_id` int(11) NOT NULL COMMENT '角色编号',
  `priv_id` int(11) NOT NULL COMMENT '权限编号',
  UNIQUE KEY `UNQ_RP` (`role_id`,`priv_id`),
  KEY `FK_RP_REF_PRIV` (`priv_id`),
  KEY `FK_RP_REF_ROLE` (`role_id`),
  CONSTRAINT `FK_RP_REF_PRIV` FOREIGN KEY (`priv_id`) REFERENCES `f_privilege` (`priv_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_RP_REF_ROLE` FOREIGN KEY (`role_id`) REFERENCES `f_role` (`role_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='角色权限表，1个角色可以有多个权限，1个权限也可以给多个角色使用';


LOCK TABLES `ref_role_priv` WRITE;
/*!40000 ALTER TABLE `ref_role_priv` DISABLE KEYS */;
/*!40000 ALTER TABLE `ref_role_priv` ENABLE KEYS */;
UNLOCK TABLES;


DROP TABLE IF EXISTS `ref_user_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_user_role` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  UNIQUE KEY `UNQ_REF_UR` (`user_id`,`role_id`),
  KEY `FK_REF_UR_ROLE` (`role_id`),
  KEY `FK_REF_UR_USER` (`user_id`),
  CONSTRAINT `FK_UR_REF_ROLE` FOREIGN KEY (`role_id`) REFERENCES `f_role` (`role_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_UR_REF_USER` FOREIGN KEY (`user_id`) REFERENCES `f_user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='用户角色表，1个用户可以有多个角色';


LOCK TABLES `ref_user_role` WRITE;
/*!40000 ALTER TABLE `ref_user_role` DISABLE KEYS */;
/*!40000 ALTER TABLE `ref_user_role` ENABLE KEYS */;
UNLOCK TABLES;

