import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { LoginlogComponent } from './loginlog.component';

describe('LoginlogComponent', () => {
  let component: LoginlogComponent;
  let fixture: ComponentFixture<LoginlogComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ LoginlogComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(LoginlogComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
