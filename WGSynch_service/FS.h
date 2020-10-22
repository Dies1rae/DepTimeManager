#pragma once
#include "settings.h"
#include "company.h"
#include "mysql.h"
#include <vector>
#include <string>
#include <algorithm>
#include <fstream>
#include <iostream>

class FS {
private:
	settings main_settings_;
	company all_users_base;
	std::string settings_file_path_;

public:
	explicit FS();
	explicit FS(const std::string& settings_file_path);

	void init_settings();
	void init_all_users_base();
	void main_loop();
	void sql_load_data();
};

