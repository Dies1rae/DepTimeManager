#pragma once
#include "settings.h"
#include "company.h"
#include "mysql.h"
#include <vector>
#include <string>
#include <algorithm>
#include <fstream>
#include <iostream>
#include <stdlib.h>
#include <stdio.h>
#include <stdio.h>
#include <windows.h>
using namespace std::string_literals;

class FS {
private:

	settings main_settings_;
	company all_users_base;
	std::string settings_file_path_;

	void sql_droptable_root() {
		int qstate = 0;
		MYSQL* conn;
		MYSQL_ROW row;
		MYSQL_RES* res;
		conn = mysql_init(0);
		conn = mysql_real_connect(conn, "___", "___", "___", "___", 3306, NULL, 0);
		mysql_query(conn, "set names cp1251");
		if (conn) {
			std::cout << "MYSQL db connected"s << std::endl;
			std::string query = "DROP TABLE root;";
			const char* q1 = query.c_str();
			qstate = mysql_query(conn, q1);
			if (qstate != 0) {
				std::cerr << mysql_error(conn) << std::endl;
			}
		} else {
			std::cout << "MYSQL db connection failed!"s << std::endl;
		}
		mysql_close(conn);
	}

	void sql_createtable_root() {
		int qstate = 0;
		MYSQL* conn;
		MYSQL_ROW row;
		MYSQL_RES* res;

		conn = mysql_init(0);
		conn = mysql_real_connect(conn, "___", "___", "___", "___", 3306, NULL, 0);
		mysql_query(conn, "set names cp1251");
		if (conn) {
			std::cout << "MYSQL db connected"s << std::endl;
			std::string query = "CREATE TABLE root (   r_uid int(10) unsigned NOT NULL AUTO_INCREMENT,   dep text,   name text,   account text,   email text,   mobile text,   position text,   snilz text,   extel text,   PRIMARY KEY (r_uid) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
			const char* q1 = query.c_str();
			qstate = mysql_query(conn, q1);
			if (qstate != 0) {
				std::cerr << mysql_error(conn) << std::endl;
			}

		} else {
			std::cout << "MYSQL db connection failed!"s << std::endl;
		}

		mysql_close(conn);
	}

	void sql_load_data() {
		int qstate = 0;
		MYSQL* conn;
		MYSQL_ROW row;
		MYSQL_RES* res;
		conn = mysql_init(0);
		conn = mysql_real_connect(conn, "___", "___", "___", "___", 3306, NULL, 0);
		mysql_query(conn, "set names cp1251");
		if (conn) {
			std::cout << "MYSQL db connected"s << std::endl;
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
					"', '" + this->all_users_base.Get_Users()[upointer].Get_Userdata()[8] + "')";
				const char* q1 = query.c_str();
				qstate = mysql_query(conn, q1);
				if (qstate != 0) {
					std::cerr << mysql_error(conn) << std::endl;
				}
			}
		} else {
			std::cout << "MYSQL db connection failed!"s << std::endl;
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
	}

	void init_settings() {
		std::vector<std::string> settings_string;
		std::ifstream settings_file(this->settings_file_path_, std::ios::binary);
		std::string tmp_sett;

		if (settings_file.is_open()) {
			while (std::getline(settings_file, tmp_sett)) {
				settings_string.push_back(tmp_sett);
			}
			settings_file.close();
		}

		settings_string.erase(remove_if(settings_string.begin(), settings_string.end(), [](std::string& A) {
			if (A.find("[DBSETTINGS]"s) != std::string::npos || A.find("[INFOFILE]"s) != std::string::npos) {
				return 1;
			} else {
				return 0;
			}
			}), settings_string.end());
		this->main_settings_.set_db_address(settings_string[0]);
		this->main_settings_.set_db_port(settings_string[1]);
		this->main_settings_.set_db_name(settings_string[2]);
		this->main_settings_.set_db_login(settings_string[3]);
		this->main_settings_.set_db_password(settings_string[4]);
		this->main_settings_.set_infofile_path(settings_string[5]);

	}

	void init_all_users_base() {
		this->all_users_base.Get_Users().clear();
		std::ifstream user_infofile(this->main_settings_.get_infofile_path(), std::ios::binary);
		std::vector<std::string> tmp_usersinfo(8);
		if (user_infofile.is_open()) {
			while (user_infofile.good()) {
				std::getline(user_infofile, tmp_usersinfo[0], ';');
				std::getline(user_infofile, tmp_usersinfo[1], ';');
				std::getline(user_infofile, tmp_usersinfo[2], ';');
				std::getline(user_infofile, tmp_usersinfo[3], ';');
				std::getline(user_infofile, tmp_usersinfo[4], ';');
				std::getline(user_infofile, tmp_usersinfo[5], ';');
				std::getline(user_infofile, tmp_usersinfo[6], ';');
				std::getline(user_infofile, tmp_usersinfo[7], '\n');

				user tmp_userdata(tmp_usersinfo[0], tmp_usersinfo[1], tmp_usersinfo[2], tmp_usersinfo[3],
					tmp_usersinfo[4], tmp_usersinfo[5], tmp_usersinfo[6], tmp_usersinfo[7]);
				tmp_userdata.Data_Corrections();
				this->all_users_base.Add_Users(tmp_userdata);
			}
			user_infofile.close();
		}

	}

public:
	explicit FS();
	explicit FS(const std::string& settings_file_path);

	void main_loop();
};

