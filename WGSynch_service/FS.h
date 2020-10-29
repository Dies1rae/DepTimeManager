#pragma once
#include "logg.h"
#include "company.h"
#include "settings.h"
#include "mysql.h"
#include <vector>
#include <string>
#include <algorithm>
#include <fstream>
#include <iostream>
#include <stdlib.h>
#include <stdio.h>
#include <cstring>
#include <windows.h>
using namespace std::string_literals;

class FS {
private:
	//----settings shit
	bool userfile_check;
	const std::string settings_file_path_;
	//----
	company all_users_base;
	settings main_settings_;
	logg* main_log_container_;

	//private methods
	void sql_droptable_root() {
		int qstate = 0;
		MYSQL* conn;
		MYSQL_ROW row;
		MYSQL_RES* res;
		conn = mysql_init(0);
		conn = mysql_real_connect(conn, main_settings_.get_db_address().c_str(), main_settings_.get_db_login().c_str(),
			main_settings_.get_db_password().c_str(), main_settings_.get_db_name().c_str(), main_settings_.get_db_port(), NULL, 0);
		mysql_query(conn, "set names cp1251");
		if (conn) {
			std::string query = "DROP TABLE root;";
			
			const char* q1 = query.c_str();
			qstate = mysql_query(conn, q1);
			if (qstate != 0) {
				std::cerr << mysql_error(conn) << std::endl;
			}
		}
		mysql_close(conn);
	}

	void sql_createtable_root() {
		int qstate = 0;
		MYSQL* conn;
		MYSQL_ROW row;
		MYSQL_RES* res;

		conn = mysql_init(0);
		conn = mysql_real_connect(conn, main_settings_.get_db_address().c_str(), main_settings_.get_db_login().c_str(),
			main_settings_.get_db_password().c_str(), main_settings_.get_db_name().c_str(), main_settings_.get_db_port(), NULL, 0);
		mysql_query(conn, "set names cp1251");
		if (conn) {
			std::string query = "CREATE TABLE root (   r_uid int(10) unsigned NOT NULL AUTO_INCREMENT,   dep text,   account text,   email text,   mobile text,   name text,   position text,   snilz text,   extel text, status int(1) not null,  PRIMARY KEY (r_uid) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
			const char* q1 = query.c_str();
			qstate = mysql_query(conn, q1);
			if (qstate != 0) {
				std::cerr << mysql_error(conn) << std::endl;
			}

		} 
		mysql_close(conn);
	}

	void sql_update_db() {
		sql_droptable_root();
		this->main_log_container_->add_log_string("DROP table OK!"s);

		sql_createtable_root();
		this->main_log_container_->add_log_string("CREATE table OK!"s);

		sql_load_data();
		this->main_log_container_->add_log_string("Load data to SQL table OK!"s);

		copy_userinfo_file_toroot_folder();
		this->main_log_container_->add_log_string("Copy *csv user info file to root folder like bckp OK!"s);

		delete_userinfo_file();
		this->main_log_container_->add_log_string("Cleaning OK!"s);
	}

	void sql_load_data() {
		int qstate = 0;
		MYSQL* conn;
		MYSQL_ROW row;
		MYSQL_RES* res;
		conn = mysql_init(0);
		conn = mysql_real_connect(conn, main_settings_.get_db_address().c_str(), main_settings_.get_db_login().c_str(),
			main_settings_.get_db_password().c_str(), main_settings_.get_db_name().c_str(), main_settings_.get_db_port(), NULL, 0);
		mysql_query(conn, "set names cp1251");
		
		if (conn) {
			for (size_t upointer = 0; upointer < this->all_users_base.Get_Users().size(); upointer++) {
				std::string query = "INSERT INTO root VALUES ("
					+ this->all_users_base.Get_Users()[upointer].Get_Userdata()[0] +
					", '" + this->all_users_base.Get_Users()[upointer].Get_Userdata()[1] +
					"', '" + this->all_users_base.Get_Users()[upointer].Get_Userdata()[2] +
					"', '" + this->all_users_base.Get_Users()[upointer].Get_Userdata()[3] +
					"', '" + this->all_users_base.Get_Users()[upointer].Get_Userdata()[4] +
					"', '" + this->all_users_base.Get_Users()[upointer].Get_Userdata()[5] +
					"', '" + this->all_users_base.Get_Users()[upointer].Get_Userdata()[6] +
					"', '" + this->all_users_base.Get_Users()[upointer].Get_Userdata()[7] +
					"', '" + this->all_users_base.Get_Users()[upointer].Get_Userdata()[8] +
					"', '" + this->all_users_base.Get_Users()[upointer].Get_Userdata()[9] + "')";
				const char* q1 = query.c_str();
				qstate = mysql_query(conn, q1);
				if (qstate != 0) {
					std::cerr << mysql_error(conn) << std::endl;
				}
			}
		}
		mysql_close(conn);
	}
	
	void copy_userinfo_file_toroot_folder() {
		std::string filenameout = ".\\";
		filenameout += main_settings_.get_infofile_path().substr(main_settings_.get_infofile_path().find_last_of("\\"), main_settings_.get_infofile_path().find_last_of("."));
		filenameout += "_bckp.csv";
		std::ifstream src_txt(main_settings_.get_infofile_path(), std::ios::binary);
		std::ofstream dest_txt(filenameout, std::ios::binary);
		dest_txt << src_txt.rdbuf();
		src_txt.close();
		dest_txt.close();
	}

	void delete_userinfo_file() {
		remove(main_settings_.get_infofile_path().c_str());
	}

public:

	explicit FS();
	explicit FS(logg* L);
	explicit FS(const std::string& settings_file_path);
	explicit FS(logg* L, const std::string& settings_file_path);

	void userfile_base_check();
	void init_all_users_base();
	void main_loop();
};

