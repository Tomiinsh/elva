USE [elva]
GO
/****** Object:  Table [dbo].[auth_assignment]    Script Date: 04/05/2021 19:06:52 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[auth_assignment](
	[item_name] [nvarchar](64) NOT NULL,
	[user_id] [nvarchar](64) NOT NULL,
	[created_at] [int] NULL,
PRIMARY KEY CLUSTERED 
(
	[item_name] ASC,
	[user_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[auth_item]    Script Date: 04/05/2021 19:06:52 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[auth_item](
	[name] [nvarchar](64) NOT NULL,
	[type] [smallint] NOT NULL,
	[description] [nvarchar](max) NULL,
	[rule_name] [nvarchar](64) NULL,
	[data] [varbinary](max) NULL,
	[created_at] [int] NULL,
	[updated_at] [int] NULL,
PRIMARY KEY CLUSTERED 
(
	[name] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[auth_item_child]    Script Date: 04/05/2021 19:06:52 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[auth_item_child](
	[parent] [nvarchar](64) NOT NULL,
	[child] [nvarchar](64) NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[parent] ASC,
	[child] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[auth_rule]    Script Date: 04/05/2021 19:06:52 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[auth_rule](
	[name] [nvarchar](64) NOT NULL,
	[data] [nvarchar](max) NULL,
	[created_at] [int] NULL,
	[updated_at] [int] NULL,
PRIMARY KEY CLUSTERED 
(
	[name] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[construction_site]    Script Date: 04/05/2021 19:06:52 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[construction_site](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[name] [varchar](100) NOT NULL,
	[location] [varchar](100) NOT NULL,
	[quadrature] [int] NOT NULL,
	[manager_id] [int] NULL,
 CONSTRAINT [PK_CONSTRUCTION_SITE] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[employee]    Script Date: 04/05/2021 19:06:52 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[employee](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[first_name] [varchar](50) NOT NULL,
	[last_name] [varchar](50) NOT NULL,
	[date_of_birth] [date] NOT NULL,
	[manager_id] [int] NULL,
 CONSTRAINT [PK_EMPLOYEE] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[employee_construction_site]    Script Date: 04/05/2021 19:06:52 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[employee_construction_site](
	[employee_id] [int] NOT NULL,
	[construction_site_id] [int] NOT NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[employee_work_item]    Script Date: 04/05/2021 19:06:52 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[employee_work_item](
	[employee_id] [int] NOT NULL,
	[work_item_id] [int] NOT NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[user]    Script Date: 04/05/2021 19:06:52 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[user](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[username] [varchar](50) NOT NULL,
	[password] [varchar](60) NOT NULL,
	[auth_key] [varchar](60) NOT NULL,
	[access_token] [varchar](60) NOT NULL,
	[employee_id] [int] NULL,
 CONSTRAINT [PK_user] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[work_item]    Script Date: 04/05/2021 19:06:52 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[work_item](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[name] [varchar](100) NOT NULL,
	[description] [text] NOT NULL,
	[construction_site_id] [int] NOT NULL,
 CONSTRAINT [PK_WORK_ITEM] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
INSERT [dbo].[auth_assignment] ([item_name], [user_id], [created_at]) VALUES (N'admin', N'4', 1619613286)
INSERT [dbo].[auth_assignment] ([item_name], [user_id], [created_at]) VALUES (N'employee', N'1025', 1620137151)
INSERT [dbo].[auth_assignment] ([item_name], [user_id], [created_at]) VALUES (N'employee', N'1026', 1620137183)
INSERT [dbo].[auth_assignment] ([item_name], [user_id], [created_at]) VALUES (N'employee', N'1027', 1620137213)
INSERT [dbo].[auth_assignment] ([item_name], [user_id], [created_at]) VALUES (N'employee', N'1031', 1620137365)
INSERT [dbo].[auth_assignment] ([item_name], [user_id], [created_at]) VALUES (N'employee', N'1032', 1620137386)
INSERT [dbo].[auth_assignment] ([item_name], [user_id], [created_at]) VALUES (N'employee', N'1033', 1620137414)
INSERT [dbo].[auth_assignment] ([item_name], [user_id], [created_at]) VALUES (N'manager', N'1028', 1620137258)
INSERT [dbo].[auth_assignment] ([item_name], [user_id], [created_at]) VALUES (N'manager', N'1029', 1620137292)
INSERT [dbo].[auth_assignment] ([item_name], [user_id], [created_at]) VALUES (N'manager', N'1030', 1620137327)
GO
INSERT [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'admin', 1, NULL, NULL, NULL, 1619613279, 1619613279)
INSERT [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'assign_work_items', 2, N'Assign work items', NULL, NULL, 1620027088, 1620027088)
INSERT [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'can_have_manager', 2, N'User can have manager', NULL, NULL, 1619691447, 1619691478)
INSERT [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'can_manage_work_item', 2, N'Can manage work items', N'can_manage_work_item', NULL, 1620027703, 1620027703)
INSERT [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'employee', 1, NULL, NULL, NULL, 1619613279, 1619613279)
INSERT [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'manage_construction_sites', 2, N'Manage construction sites', NULL, NULL, 1619613279, 1619613279)
INSERT [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'manage_employees', 2, N'Manage employees', NULL, NULL, 1620025425, 1620025425)
INSERT [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'manage_users', 2, N'Manage users', NULL, NULL, 1619613279, 1619613279)
INSERT [dbo].[auth_item] ([name], [type], [description], [rule_name], [data], [created_at], [updated_at]) VALUES (N'manager', 1, NULL, NULL, NULL, 1619613279, 1619613279)
GO
INSERT [dbo].[auth_item_child] ([parent], [child]) VALUES (N'admin', N'can_manage_work_item')
INSERT [dbo].[auth_item_child] ([parent], [child]) VALUES (N'admin', N'manage_construction_sites')
INSERT [dbo].[auth_item_child] ([parent], [child]) VALUES (N'admin', N'manage_employees')
INSERT [dbo].[auth_item_child] ([parent], [child]) VALUES (N'admin', N'manage_users')
INSERT [dbo].[auth_item_child] ([parent], [child]) VALUES (N'employee', N'can_have_manager')
INSERT [dbo].[auth_item_child] ([parent], [child]) VALUES (N'manager', N'assign_work_items')
INSERT [dbo].[auth_item_child] ([parent], [child]) VALUES (N'manager', N'can_manage_work_item')
GO
INSERT [dbo].[auth_rule] ([name], [data], [created_at], [updated_at]) VALUES (N'can_manage_work_item', N'O:26:"app\rbac\CanManageWorkItem":3:{s:4:"name";s:20:"can_manage_work_item";s:9:"createdAt";i:1620027647;s:9:"updatedAt";i:1620027647;}', 1620027647, 1620027647)
GO
SET IDENTITY_INSERT [dbo].[construction_site] ON 

INSERT [dbo].[construction_site] ([id], [name], [location], [quadrature], [manager_id]) VALUES (1006, N'Z-Towers', N'Rīga', 100000, 2051)
INSERT [dbo].[construction_site] ([id], [name], [location], [quadrature], [manager_id]) VALUES (1007, N'Lielais Dzintars', N'Liepāja', 14126, 2052)
INSERT [dbo].[construction_site] ([id], [name], [location], [quadrature], [manager_id]) VALUES (1008, N'Origo', N'Rīga', 35000, 2053)
SET IDENTITY_INSERT [dbo].[construction_site] OFF
GO
SET IDENTITY_INSERT [dbo].[employee] ON 

INSERT [dbo].[employee] ([id], [first_name], [last_name], [date_of_birth], [manager_id]) VALUES (1027, N'administrator', N'administrator', CAST(N'1925-10-23' AS Date), NULL)
INSERT [dbo].[employee] ([id], [first_name], [last_name], [date_of_birth], [manager_id]) VALUES (2048, N'Jānis', N'Bērziņš', CAST(N'2021-04-28' AS Date), 2052)
INSERT [dbo].[employee] ([id], [first_name], [last_name], [date_of_birth], [manager_id]) VALUES (2049, N'Oskars', N'Bērziņš', CAST(N'2021-04-29' AS Date), 2052)
INSERT [dbo].[employee] ([id], [first_name], [last_name], [date_of_birth], [manager_id]) VALUES (2050, N'Edgars', N'Bērziņš', CAST(N'2021-04-29' AS Date), 2051)
INSERT [dbo].[employee] ([id], [first_name], [last_name], [date_of_birth], [manager_id]) VALUES (2051, N'Elvis', N'Liepa', CAST(N'2021-04-29' AS Date), NULL)
INSERT [dbo].[employee] ([id], [first_name], [last_name], [date_of_birth], [manager_id]) VALUES (2052, N'Mārtiņš', N'Liepa', CAST(N'2021-04-28' AS Date), NULL)
INSERT [dbo].[employee] ([id], [first_name], [last_name], [date_of_birth], [manager_id]) VALUES (2053, N'Raivo', N'Liepa', CAST(N'2021-04-29' AS Date), NULL)
INSERT [dbo].[employee] ([id], [first_name], [last_name], [date_of_birth], [manager_id]) VALUES (2054, N'Sandis', N'Egle', CAST(N'2021-04-28' AS Date), 2051)
INSERT [dbo].[employee] ([id], [first_name], [last_name], [date_of_birth], [manager_id]) VALUES (2055, N'Vitālijs', N'Egle', CAST(N'2021-04-28' AS Date), 2053)
INSERT [dbo].[employee] ([id], [first_name], [last_name], [date_of_birth], [manager_id]) VALUES (2056, N'Ernests', N'Egle', CAST(N'2021-04-29' AS Date), 2053)
SET IDENTITY_INSERT [dbo].[employee] OFF
GO
INSERT [dbo].[employee_construction_site] ([employee_id], [construction_site_id]) VALUES (2050, 1006)
INSERT [dbo].[employee_construction_site] ([employee_id], [construction_site_id]) VALUES (2054, 1006)
INSERT [dbo].[employee_construction_site] ([employee_id], [construction_site_id]) VALUES (2048, 1007)
INSERT [dbo].[employee_construction_site] ([employee_id], [construction_site_id]) VALUES (2049, 1007)
GO
INSERT [dbo].[employee_work_item] ([employee_id], [work_item_id]) VALUES (2050, 2012)
INSERT [dbo].[employee_work_item] ([employee_id], [work_item_id]) VALUES (2054, 2012)
INSERT [dbo].[employee_work_item] ([employee_id], [work_item_id]) VALUES (2050, 2018)
INSERT [dbo].[employee_work_item] ([employee_id], [work_item_id]) VALUES (2054, 2018)
INSERT [dbo].[employee_work_item] ([employee_id], [work_item_id]) VALUES (2048, 2014)
INSERT [dbo].[employee_work_item] ([employee_id], [work_item_id]) VALUES (2049, 2015)
GO
SET IDENTITY_INSERT [dbo].[user] ON 

INSERT [dbo].[user] ([id], [username], [password], [auth_key], [access_token], [employee_id]) VALUES (4, N'administrator', N'$2y$13$Ap4pR3XRDXwIHYIZlopNROzRdf3cmeEo3bSBMN1ARBDvbqdBcZ3WC', N'GBbkLw85uwapsS09_49meZf_wP5pCzcziBz2TevCZHlg8KZwv1sfMiAw8Nxg', N'384ihQ4XyjuIDUtPvyG9UEOTpstD4_1jJmMPzddBOgnNv-ZwgMplf3jlMwSv', 1027)
INSERT [dbo].[user] ([id], [username], [password], [auth_key], [access_token], [employee_id]) VALUES (1025, N'employee', N'$2y$13$2UVPiWxxb5qRHWYVXrEVwegCMeVuc9uauW7zkBMLQDNbO22uEfEIy', N'lSU73oOL5Lwr-0uMjnGrvdUYcV_s4Xboqlwc7-za7RLTq47rempaeR6m29b7', N'uNt0KBuN89nzFGzs6tjBzITV4VtixNyZGDSzRbsMybom4zGKfB8P0zJojp4a', 2048)
INSERT [dbo].[user] ([id], [username], [password], [auth_key], [access_token], [employee_id]) VALUES (1026, N'employee1', N'$2y$13$uCfFDVxkHno9C8QeJ7VDB.zeS.pf8Rg.8neEBWSncLPkPmLU9XAcK', N'loCuYfS1qhBjgG-YMG9-OkVMGLfRV7_6tBsBCoz7OwN3xAlEv_Tuy_Epi2eP', N'KQLeOWmAx4GjY9MHkbjKTwgbjRbUUkPvJQstr6c-5m-oFUHZ2W0qq_p1eieT', 2049)
INSERT [dbo].[user] ([id], [username], [password], [auth_key], [access_token], [employee_id]) VALUES (1027, N'employee2', N'$2y$13$0PkUqsPegGpLuNuwEeOb8.dbKIVBJSnj98c8JHMeKjV9ds.C3/0va', N'lCMsuA6R6oD-mkXGgZsgSV90pG0wLOCL8q6NPnUqrQtK8f5YzrdaWAhf8IrD', N'0M-EOMtl9O7CVr8FTOM0_TanlOaBGb0flCD9gFfCAGItyMjKznFs13e13cYw', 2050)
INSERT [dbo].[user] ([id], [username], [password], [auth_key], [access_token], [employee_id]) VALUES (1028, N'manager', N'$2y$13$Ew./qPDl/gUV0O0Ayf6MDuV7/.rqov2R6HYglD7RhAAZuCz6Z3Wz6', N'HckuJ83vbaN4QTmiz_FJenp4ETle-z8NvK94jQwV0zxk4XSjf7mA2xTQ5YhT', N'BUgENgnyQlTOS3FcE_TqiJY822M948BXkmF2EEEYTLTUAcJmlBuHl8UnnrAP', 2051)
INSERT [dbo].[user] ([id], [username], [password], [auth_key], [access_token], [employee_id]) VALUES (1029, N'manager1', N'$2y$13$FMO/oKIM5HfP4g4wum4dHuhugoIfsby84anMX5ML7I0x.4PUozlhO', N'n9SWQN3_IPUhhi3G_4BtpU3g0dUN0FxNlP1GrkrSvbelbbImul7Dlftl-Ugg', N'uk80-ZQKpOVerQ-ZO4njRLqMubW5lQ86G6KKVuC0jXsMteRMI11i6tO6aLSM', 2052)
INSERT [dbo].[user] ([id], [username], [password], [auth_key], [access_token], [employee_id]) VALUES (1030, N'manager2', N'$2y$13$dhqcGxuraVVLibXNp5I5b.9frok8it9tOoK768NOgC2DYv.6Bw.4S', N're-dvvW0w5g39YTa7DSlgmQjatid7PJRfl4T0nIrLsuOPk-MIC_O57b5n9Dw', N'a4459MoQSL2ONztMTE-2cI7Pghl2aW3SeXhxD4Yv02uR3_jwzEjDSrk1g7Tb', 2053)
INSERT [dbo].[user] ([id], [username], [password], [auth_key], [access_token], [employee_id]) VALUES (1031, N'employee4', N'$2y$13$Qh7HweVYZdvIpjy/htR2cOutnoeCBdoXYy3leVC4L7D5q5mtj7X3K', N'llIdt4llVHOniQSSlesT_dX96v0S-yjvkm9V7sK3cHmK6LqGj9n-KoBTWmDd', N'0wslnfja8N4uB6LhXPq2vQBpfFnM5C3zv3khb0dssg_N7D3FkVhg1JmZYQJi', 2054)
INSERT [dbo].[user] ([id], [username], [password], [auth_key], [access_token], [employee_id]) VALUES (1032, N'employee5', N'$2y$13$KVbzdIPf3EfH85jUtz9lY.VVrdSPgM43CXWEshMgjaRkzbCQ0dI22', N'SX3nOSoDkIzvt0NYTd3w41nkGFO9JQbx-rWJhhRTZjUJ0iMRVCe8-AEBuiMO', N'xNoYFyGdWtrAnGd3aIt7hgkl9QCCMX-I32ZulAq3220K_TB3C8eBVkqFaQXL', 2055)
INSERT [dbo].[user] ([id], [username], [password], [auth_key], [access_token], [employee_id]) VALUES (1033, N'employee6', N'$2y$13$ZEHCaNj9flSeLm5cu2vQX.EHgMFJ5LCc2OimFmI/SYLIP2TSe.s6i', N'4ZA487adsJXE1bLCVe5tGQmcJSS4Fi1t2691Lm-oQNojO4aiw45LnBpIBBsI', N'Oj39RS35OGzzXmw4OEneFbNLnDGEA3vBFutHtVcvn3zFBmnCPadtSo_X4N_q', 2056)
SET IDENTITY_INSERT [dbo].[user] OFF
GO
SET IDENTITY_INSERT [dbo].[work_item] ON 

INSERT [dbo].[work_item] ([id], [name], [description], [construction_site_id]) VALUES (2012, N'Betonēšana', N'Betonēt būvobjekta pamatus.', 1006)
INSERT [dbo].[work_item] ([id], [name], [description], [construction_site_id]) VALUES (2014, N'Elektroinstalācijas', N'Elektroinstalācijas ierīkošana būvobjektā.', 1007)
INSERT [dbo].[work_item] ([id], [name], [description], [construction_site_id]) VALUES (2015, N'Kosmētiskais remonts', N'Veikt objekta iekšdares kosmētisko remontu.', 1007)
INSERT [dbo].[work_item] ([id], [name], [description], [construction_site_id]) VALUES (2016, N'Rasējums', N'Sagatavot rasējumu objekta piebūvei.', 1008)
INSERT [dbo].[work_item] ([id], [name], [description], [construction_site_id]) VALUES (2018, N'Betona piegādāšana', N'Piegādāt betona masu būvobjektā.', 1006)
SET IDENTITY_INSERT [dbo].[work_item] OFF
GO
ALTER TABLE [dbo].[auth_assignment]  WITH CHECK ADD FOREIGN KEY([item_name])
REFERENCES [dbo].[auth_item] ([name])
GO
ALTER TABLE [dbo].[auth_item]  WITH CHECK ADD FOREIGN KEY([rule_name])
REFERENCES [dbo].[auth_rule] ([name])
GO
ALTER TABLE [dbo].[auth_item_child]  WITH CHECK ADD FOREIGN KEY([child])
REFERENCES [dbo].[auth_item] ([name])
GO
ALTER TABLE [dbo].[auth_item_child]  WITH CHECK ADD FOREIGN KEY([parent])
REFERENCES [dbo].[auth_item] ([name])
GO
ALTER TABLE [dbo].[construction_site]  WITH CHECK ADD  CONSTRAINT [FK_construction_site_employee] FOREIGN KEY([manager_id])
REFERENCES [dbo].[employee] ([id])
ON DELETE SET NULL
GO
ALTER TABLE [dbo].[construction_site] CHECK CONSTRAINT [FK_construction_site_employee]
GO
ALTER TABLE [dbo].[employee]  WITH CHECK ADD  CONSTRAINT [FK_EMPLOYEE_EMPLOYEE] FOREIGN KEY([id])
REFERENCES [dbo].[employee] ([id])
GO
ALTER TABLE [dbo].[employee] CHECK CONSTRAINT [FK_EMPLOYEE_EMPLOYEE]
GO
ALTER TABLE [dbo].[employee_construction_site]  WITH CHECK ADD  CONSTRAINT [FK_employee_construction_site_construction_site] FOREIGN KEY([construction_site_id])
REFERENCES [dbo].[construction_site] ([id])
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[employee_construction_site] CHECK CONSTRAINT [FK_employee_construction_site_construction_site]
GO
ALTER TABLE [dbo].[employee_construction_site]  WITH CHECK ADD  CONSTRAINT [FK_employee_construction_site_employee] FOREIGN KEY([employee_id])
REFERENCES [dbo].[employee] ([id])
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[employee_construction_site] CHECK CONSTRAINT [FK_employee_construction_site_employee]
GO
ALTER TABLE [dbo].[employee_work_item]  WITH CHECK ADD  CONSTRAINT [FK_employee_work_item_employee] FOREIGN KEY([employee_id])
REFERENCES [dbo].[employee] ([id])
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[employee_work_item] CHECK CONSTRAINT [FK_employee_work_item_employee]
GO
ALTER TABLE [dbo].[employee_work_item]  WITH CHECK ADD  CONSTRAINT [FK_employee_work_item_work_item] FOREIGN KEY([work_item_id])
REFERENCES [dbo].[work_item] ([id])
GO
ALTER TABLE [dbo].[employee_work_item] CHECK CONSTRAINT [FK_employee_work_item_work_item]
GO
ALTER TABLE [dbo].[user]  WITH CHECK ADD  CONSTRAINT [FK_user_employee] FOREIGN KEY([employee_id])
REFERENCES [dbo].[employee] ([id])
ON DELETE SET NULL
GO
ALTER TABLE [dbo].[user] CHECK CONSTRAINT [FK_user_employee]
GO
ALTER TABLE [dbo].[work_item]  WITH CHECK ADD  CONSTRAINT [FK_WORK_ITEM_CONSTRUCTION_SITE] FOREIGN KEY([construction_site_id])
REFERENCES [dbo].[construction_site] ([id])
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[work_item] CHECK CONSTRAINT [FK_WORK_ITEM_CONSTRUCTION_SITE]
GO
