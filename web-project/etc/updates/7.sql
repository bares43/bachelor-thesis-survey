ALTER TABLE `subquestion`
CHANGE `correct` `state` tinyint(1) NULL COMMENT '0 - ne 1 - ano 2 - temer 3 - nepocitane null - neovereno' AFTER `answer`,
DROP `visible`;