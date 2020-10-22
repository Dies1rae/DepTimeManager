#include "company.h"


company::company() = default;

void company::Add_Users(user user) {
	this->company_users_.push_back(user);
}

std::vector<user> company::Get_Users() {
	return this->company_users_;
}