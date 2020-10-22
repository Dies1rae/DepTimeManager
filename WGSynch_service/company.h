#pragma once
#include <vector>
#include "user.h"

class company {
private:
	std::vector<user> company_users_;
public:
	explicit company();
	explicit company(std::vector<user> company_users);

	void Add_Users(const user& user);
	std::vector<user> Get_Users() const;
};

