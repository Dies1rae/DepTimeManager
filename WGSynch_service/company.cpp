#include "company.h"


company::company() = default;
company::company(std::vector<user> company_users):company_users_(company_users) {}

void company::Add_Users(const user& user) {
	this->company_users_.push_back(user);
}

std::vector<user> company::Get_Users() const {
	return this->company_users_;
}