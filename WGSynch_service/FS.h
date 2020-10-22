#pragma once
#include "settings.h"
#include "company.h"
#include "mysql.h"
#include <vector>
#include <string>

class FS {
private:
	settings main_sets_;
	company all_users_base;

protected:
	MYSQL* connect_;
	MYSQL_ROW row_data_;
	MYSQL_RES* connect_result_;

public:
	explicit FS();

	void init_settings();
	void init_settings(const std::string& file_path);
	void init_all_users_base();
	void main_loop();
	void sql_load_data();
};

