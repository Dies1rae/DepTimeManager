#pragma once
#include <vector>
#include "user.h"

class company {
private:
	std::vector<user> company_users_;
public:
	explicit company();

	void Add_Users(user user);
	std::vector<user> Get_Users();
};

