#pragma once
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
	const std::string settings_file_path_;
	//----
	company all_users_base;
	settings main_settings_;

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
		init_all_users_base();
		std::cout << "Init userfile OK!"s << std::endl;

		sql_droptable_root();
		std::cout << "DROP table OK!"s << std::endl;
		sql_createtable_root();
		std::cout << "CREATE table OK!"s << std::endl;
		
		sql_load_data();
		std::cout << "Load data to SQL table OK!"s << std::endl;

		copy_userinfo_file_toroot_folder();
		std::cout << "Copy *csv user info file to root folder like bckp OK!"s << std::endl;
		delete_userinfo_file();
		std::cout << "Cleaning OK!"s << std::endl;

	}

	void init_all_users_base() {
		this->all_users_base.Get_Users().clear();
		std::ifstream user_infofile(main_settings_.get_infofile_path(), std::ios::binary);
		std::vector<std::string> tmp_usersinfo(9);
		if (user_infofile.is_open()) {
			while (user_infofile.good()) {
				std::getline(user_infofile, tmp_usersinfo[0], ';');
				std::getline(user_infofile, tmp_usersinfo[1], ';');
				std::getline(user_infofile, tmp_usersinfo[2], ';');
				std::getline(user_infofile, tmp_usersinfo[3], ';');
				std::getline(user_infofile, tmp_usersinfo[4], ';');
				std::getline(user_infofile, tmp_usersinfo[5], ';');
				std::getline(user_infofile, tmp_usersinfo[6], ';');
				std::getline(user_infofile, tmp_usersinfo[7], ';');
				std::getline(user_infofile, tmp_usersinfo[8], '\n');

				int status = 1;
				tmp_usersinfo[8].find("Уволен"s) ? status = 1 : status = 0;
				
				user tmp_userdata(tmp_usersinfo[0], tmp_usersinfo[1], tmp_usersinfo[2], tmp_usersinfo[3],
					tmp_usersinfo[4], tmp_usersinfo[5], tmp_usersinfo[6], tmp_usersinfo[7], status);
				tmp_userdata.Data_Corrections();

				this->all_users_base.Add_Users(tmp_userdata);
			}
			user_infofile.close();
		}

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
		filenameout += main_settings_.get_infofile_path().substr(main_settings_.get_infofile_path().find_last_of("\\"), main_settings_.get_infofile_path().find_first_of("."));
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
	explicit FS(const std::string& settings_file_path);

	void main_loop();
};

