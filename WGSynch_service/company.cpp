#include "company.h"


company::company() = default;
company::company(std::vector<user> company_users):company_users_(company_users) {}

void company::Add_Users(const user& user) {
	this->company_users_.push_back(user);
	std::sort(this->company_users_.begin(), this->company_users_.end(), [](const auto& A, const auto& B) {
		return A.Get_Userdata()[2] < B.Get_Userdata()[2];
		});
}

std::vector<user> company::Get_Users() const {
	return this->company_users_;
}