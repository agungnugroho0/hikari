# SPEC file

%global c_vendor    %{_vendor}
%global gh_owner    %{_owner}
%global gh_project  %{_project}

Name:      %{_package}
Version:   %{_version}
Release:   %{_release}%{?dist}
Summary:   PHP library containing PDF graphic and geometric methods

Group:     Development/Libraries
License:   LGPLv3+
URL:       https://github.com/%{gh_owner}/%{gh_project}

BuildRoot: %{_tmppath}/%{name}-%{version}-%{release}-%(%{__id_u} -n)
BuildArch: noarch

Requires:  php(language) >= 8.1.0
Requires:  php-zlib
Requires:  php-composer(%{c_vendor}/tc-lib-color) < 3.0.0
Requires:  php-composer(%{c_vendor}/tc-lib-color) >= 2.2.13
Requires:  php-composer(%{c_vendor}/tc-lib-pdf-encrypt) < 3.0.0
Requires:  php-composer(%{c_vendor}/tc-lib-pdf-encrypt) >= 2.1.16

Provides:  php-composer(%{c_vendor}/%{gh_project}) = %{version}
Provides:  php-%{gh_project} = %{version}

%description
PHP library containing PDF graphic and geometric methods

%build
#(cd %{_current_directory} && make build)

%install
rm -rf $RPM_BUILD_ROOT
(cd %{_current_directory} && make install DESTDIR=$RPM_BUILD_ROOT)

%clean
rm -rf $RPM_BUILD_ROOT
#(cd %{_current_directory} && make clean)

%files
%attr(-,root,root) %{_libpath}
%attr(-,root,root) %{_docpath}
%docdir %{_docpath}
#%config(noreplace) %{_configpath}*

%changelog
* Mon Dec 14 2024 Nicola Asuni <info@tecnick.com> 1.0.0-1
- Initial Commit
