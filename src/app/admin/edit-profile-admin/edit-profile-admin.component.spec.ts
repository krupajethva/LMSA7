import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { EditProfileAdminComponent } from './edit-profile-admin.component';

describe('EditProfileAdminComponent', () => {
  let component: EditProfileAdminComponent;
  let fixture: ComponentFixture<EditProfileAdminComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ EditProfileAdminComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(EditProfileAdminComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
