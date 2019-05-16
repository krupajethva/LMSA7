import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { EditProfileInstructorComponent } from './edit-profile-instructor.component';

describe('EditProfileInstructorComponent', () => {
  let component: EditProfileInstructorComponent;
  let fixture: ComponentFixture<EditProfileInstructorComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ EditProfileInstructorComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(EditProfileInstructorComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
